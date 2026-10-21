<?php
use App\Models\Document;
use App\Models\Documents;
use Illuminate\Http\Request;


function single_files_upload($file, $id, $table_name, $document_type)
{
    if ($file && $file->isValid()) {

        $milisecond = round(microtime(true) * 1000);
        $name = $file->getClientOriginalName();
        $actual_name = str_replace(" ", "_", $name);
        $uploadName = $milisecond . "_" . $actual_name;
        $file->move(public_path('upload'), $uploadName);

        $documentData = [
            'image_name' => $uploadName,
            'table_name' => $table_name,
            'item_id' => $id,
            'document_type' => $document_type,
        ];

        Document::create($documentData);

        return true; // Indicate successful upload
    }

    return false; // Indicate failure to upload
}

function multiple_files_upload($files, $id, $table_name, $document_type)
{
    $uploadSuccess = true;

    // Iterate over each file and upload it
    foreach ($files as $file) {
        if ($file && $file->isValid()) {
            $milisecond = round(microtime(true) * 1000);
            $name = $file->getClientOriginalName();
            $actual_name = str_replace(" ", "_", $name);
            $uploadName = $milisecond . "_" . $actual_name;
            $file->move(public_path('upload'), $uploadName);

            $documentData[] = [
                'image_name' => $uploadName,
                'table_name' => $table_name,
                'item_id' => $id,
                'document_type' => $document_type,
            ];
        } else {
            // If any file is invalid, set $uploadSuccess to false
            $uploadSuccess = false;
        }
    }

    // Insert all document data into the database in one go
    if ($uploadSuccess) {
        Documents::insert($documentData);
    }

    return $uploadSuccess;
}

?>