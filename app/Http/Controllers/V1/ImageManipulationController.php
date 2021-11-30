<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\ImageManipulation;
use App\Models\Album;
use App\Http\Requests\StoreImageManipulationRequest;
use App\Http\Requests\UpdateImageManipulationRequest;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Resources\V1\ImageManipulationResource;
use File;
use Str;





class ImageManipulationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ImageManipulationResource::collection(ImageManipulation::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreImageManipulationRequest  $request
     * @return \Illuminate\Http\Response
     */
     // http://127.0.0.1:8000/api/v1/image/resize?w=50%   API SAMPLE  URL REQUEST

    public function store(StoreImageManipulationRequest $request)
    {
        $all = $request->all();

        // echo "<pre>";
        // return $all;
        // echo "</pre>";

        // exit;

        $image = $all['image'];

        


           $data =  [
                    'type' =>'resize',
                    'data' => json_encode($all),
                    'user_id' => null, 
           ];
       

            if(isset($all['album_id'])) {
                // TODO 

                $data['album_id'] = $all['album_id'];
            }

            $dir = 'images/'.Str::random().'/';
            $absolutePath  = public_path($dir);

            File::makeDirectory($absolutePath);


            if($image instanceof UploadedFile) {

                echo "Uploading Image From </br> Image Upload";

                $data['name'] = $image->getClientOriginalName();

                // test.jpg   -> test-resized.jpg

                $filename = pathinfo($data['name'],PATHINFO_FILENAME);

                $extension = $image->getClientOriginalExtension();

                $image->move($absolutePath,$data['name']);

                $original_path = $absolutePath.$data['name'];

                $data['path'] = $original_path;

            }else{

                echo "Uploading Image From </br> Image URL";
              
                 
                $data['name'] = pathinfo($image,PATHINFO_BASENAME);
                $filename = pathinfo($image,PATHINFO_FILENAME);
                $extension = pathinfo($image,PATHINFO_EXTENSION);

                $original_path = $absolutePath.$data['name'];

                copy($image,$original_path);

                $data['path'] = $dir.$data['name'];

              

            }

           $w = $all['w'];
           $h = $all['h'] ?? false;



          list($width, $height, $image_resized_obj) = $this->getImageWidthAndHeight($w,$h,$original_path);

          $resizedFileName = $filename.'-resized.'.$extension;

          $image_resized_obj->resize($width,$height)->save($absolutePath.$resizedFileName);

            $data['output_path'] = $dir.$resizedFileName;
            unset($all['image']);

        


            // ImageManipulation::create(
            //     [
            //         'type' =>'resize',
            //         'data' => json_encode($all),
            //         'user_id' => null, 
            //     ]);

            $imageManipulation =  ImageManipulation::create($data);
            // http://127.0.0.1:8000/api/v1/image/resize?w=50%   API SAMPLE  URL REQUEST

            return  new ImageManipulationResource($imageManipulation);


    }



    protected function getImageWidthAndHeight($w,$h,string $original_path){
           
        // 1000 - 50% => 500px   
        $image = Image::make($original_path);

        $originalWidth = $image->width();
        $originalHeight = $image->height();

        if(str_ends_with($w, "%")) {

           $rationW = (float) str_replace('%','',$w);
           $rationH = $h ? (float) str_replace('%','',$h) : $rationW;

           $newWidth = $originalWidth * $rationW / 100 ;
           $newHeight = $originalHeight * $rationH / 100 ;

        } else{
             
        /**
         *     $originalWidth - $newWidth      
         *     $originalHeight - $newHeight      
         *     $newHeight = $h ? (float) $h : $originalHeight * $newWidth / $originalWidth;
         */

        $newWidth = (float) $w;
        $newHeight = $h ? (float) $h : $originalHeight * $newWidth / $originalWidth;
        
        }
       
     return [ $newWidth , $newHeight , $image];

     

    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImageManipulation  $imageManipulation
     * @return \Illuminate\Http\Response
     */
    public function show(ImageManipulation $image)
    {
        return new ImageManipulationResource(ImageManipulation::find($image->id));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateImageManipulationRequest  $request
     * @param  \App\Models\ImageManipulation  $imageManipulation
     * @return \Illuminate\Http\Response
     */
    public function byAlbum(Album $album)
    {
        $where = [
           'album_id' => $album->id,
        ];

        return ImageManipulationResource::collection(ImageManipulation::where($where)->paginate());
    }


   

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImageManipulation  $imageManipulation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImageManipulation $image)
    {
        if($image->delete()) {
            return "  Delete Successfull";
        }else{
            return "Something Went Wrong";
        }

    }
}
