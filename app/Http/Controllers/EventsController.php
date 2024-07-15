<?php

namespace App\Http\Controllers;

use App\Models\Events;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
{
    //
    public function index(){
        return view('Events');
    }
    public function upload(Request $request){
        $uploadedFileUrl = Cloudinary::uploadFile($request->file('file')->getRealPath())->getSecurePath();
        return dd($uploadedFileUrl);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'EventName' => 'required',
            'EventType' => 'required',
            'Location' => 'required',
            'EventSchedule' => 'required',
            'Description' => 'required',
            'UrlImage' => 'required',
            'EventDate' => 'required',
            'Assistants' => 'required'
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'error de validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $uploadedFileUrl = Cloudinary::upload($request->file('UrlImage')->getRealPath(), [
            'folder' => 'event_images'
        ])->getSecurePath();

        $event = Events::create([
            'EventName' => $request->EventName,
            'EventType' => $request->EventType,
            'Location' => $request->Location,
            'EventSchedule' => $request->EventSchedule,
            'Description' => $request->Description,
            'UrlImage' => $uploadedFileUrl,
            'EventDate' => $request->EventDate,
            'Assistants' => $request->Assistants,
        ]);

        if(!$event){
            $data = [
                'message' => 'error al crear evento',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'event' => $event,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id){
        $events = Events::find($id);

        if(!$events){
            $data = [
                'message' => 'evento no encontrado',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $data = [
            'evento' => $events,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id){
        $events = Events::find($id);

        if(!$events){
            $data = [
                'message' => 'evento no encontrado',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $events->delete();

        $data = [
            'message' => 'evento eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);

    }
}
