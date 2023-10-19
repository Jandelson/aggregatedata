import sys
import json
import string
import random
import pandas as pd
from sqlalchemy import create_engine

def database(uname,pwd,hostname,dbname) -> create_engine:
    return create_engine("mysql+pymysql://{user}:{pw}@{host}/{db}"
				.format(host=hostname, db=dbname, user=uname, pw=pwd))

def generate_file_name() -> str:
    letters = string.ascii_lowercase
    return ''.join(random.choice(letters) for i in range(10)) + '.xlsx'

def agregate_data(dataframes, data_destination) -> str:
    union = pd.concat(dataframes, ignore_index=True, sort=False)
    file = generate_file_name()
    union.to_excel('/tmp/' + file)
    
    info_destionation = '--separator--';

    if data_destination:
        engine = database(
            data_destination['user_name'], 
            data_destination['password'], 
            data_destination['host'], 
            data_destination['db_name']
        )
        union.to_sql(
            data_destination['table_name'], 
            engine,
            if_exists=data_destination['if_exists'],
            index=False,
            chunksize=5000,
            method="multi")
        
        info_destionation = info_destionation + 'Data insert in destination: ' + data_destination['db_name'] + 'table: ' +   data_destination['table_name'] + ' success!'
    
    return file + info_destionation;
    
def process_file(files_path,data_destination) -> str:
    try:
        dataframes = []
        for file in files_path:
            dataframe = pd.read_excel(file)
            dataframes.append(dataframe)
            del dataframe
        
        processed_data = agregate_data(dataframes, data_destination)
        return str(processed_data)

    except Exception as e:
        print(e.args)
        sys.exit(1)

if __name__ == "__main__":
    arg = sys.argv[1]
    arg2 = sys.argv[2]
    files_path = json.loads(arg)
    destination = json.loads(arg2)
    data_destination = {}
    
    if (destination):
        data_destination = {
            'user_name': destination['user_name'],
            'host': destination['host'],
            'password': destination['password'],
            'db_name': destination['db_name'],
            'table_name': destination['table_name'],
            'if_exists': destination['if_exists']
        }
    
    print(process_file(files_path, data_destination))