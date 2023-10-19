<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestinationRequest;
use App\Models\Destination;

class DestinationController extends Controller
{
    public function __construct(private Destination $destination)
    {}
    public function index()
    {
        $data = $this->destination->first();
        return view(
            'destination',
            [
                'data' => $data,
                'if_exists' => $data->if_exists ?? ''
            ]
        );
    }

    public function store(DestinationRequest $request)
    {
        $data = $request->validated();

        $this->destination->create($data);

        return redirect()->route('destination')->with('status', 'Destination saved!');
    }

    public function update(DestinationRequest $request)
    {
        $data = $request->validated();
        
        $data['enable'] = $data['enable'] ?? false;
        
        $destination = $this->destination->first();
        $destination->update($data);

        return redirect()->route('destination')->with('status', 'Destination updated!');
    }
}
