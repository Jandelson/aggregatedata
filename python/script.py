import sys
import json
import string
import random
import pandas as pd

def generate_file_name() -> str:
    letters = string.ascii_lowercase
    return ''.join(random.choice(letters) for i in range(10)) + '.xlsx'

def agregate_data(dataframes) -> str:
    union = pd.concat(dataframes, ignore_index=True, sort=False)
    file = generate_file_name()
    union.to_excel('/tmp/' + file)
    return file;
    
def process_file(files_path) -> str:
    try:
        dataframes = []
        for file in files_path:
            dataframe = pd.read_excel(file)
            dataframes.append(dataframe)
            del dataframe
        
        processed_data = agregate_data(dataframes)
        return str(processed_data)

    except Exception as e:
        print(e.args)
        sys.exit(1)

if __name__ == "__main__":
    arg = sys.argv[1]
    files_path = json.loads(arg)

    processed_data = process_file(files_path)

    print(processed_data)