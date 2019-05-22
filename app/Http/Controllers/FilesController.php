<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('file')){
            $file = $request->file('file');
            $name = $file->getClientOriginalName();
            $file->move(public_path('/uploads/'),$name);
            $url = public_path('/uploads/'.$name);
            $aesC = new Process("python C:\laragon\www\Guardian\AES_Scripts\AES.py -c -f $url");
            $aesC->run();
            // executes after the command finishes
            if (!$aesC->isSuccessful()) {
                throw new ProcessFailedException($aesC);
            }
            $key = $aesC->getOutput();
            if(Storage::disk('ftp')->put($name, $url)){
                unlink($url);
                $message ="Archivo subido al servidor";
            }else{
                $message ="Ha ocurrido un problema...";
            }
            if ($key != 404){
                $shamirD = new Process("python C:\laragon\www\Guardian\AES_Scripts\Secret_Sharing.py -d -k $key -min 5 -max 10");
                $shamirD->run();
                // executes after the command finishes
                if (!$shamirD->isSuccessful()) {
                    throw new ProcessFailedException($shamirD);
                }
                $fragmentos = explode(",", $shamirD->getOutput());
                array_pop($fragmentos);
                //echo $fragmentos;
            }
            //dd($file);
            //Storage::disk('ftp')->put($name,$file);
            return $fragmentos;
        }
        //dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
