<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Recipe;
use App\Steps;
use App\Ingredients;

class RecipeApiController extends Controller
{
    //
    public $successStatus = 200;

    public function details(Request $request) 
    {         
             
        return response()->json(['success' => "auth success","request"=>$request->all()], $this->successStatus); 
    }

    public function getAllRecipe(Request $request)
    {
        $result = Recipe::All();
        return response()->json($result);
    }
    
    public function insertFromBbcFood(Request $request){
        $message = "";
        try{
            $data = (($request->json()->all())) ;
            \DB::beginTransaction();
            foreach($data as $data){
                $recipe = new Recipe;      
                $recipe->title = $data["title"];
                $recipe->description=$data["description"];
                $recipe->image = $data["thumbnailUrl"];
                $recipe->rating = $data["ratingStars"];
                $recipe->skill_term = $data["skillTerm"];
                $recipe->cook_time = $data["totalTime"];
                $recipe->rating = $data["ratingStars"];
                $recipe->diet_term = implode(",",$data["dietTerm"]);
                $recipe->resource_url = $data["resourceUrl"];
                $recipe->save();
                //save steps
                for($i = 0; $i < count($data["steps"]);$i++)
                {
                    $step = new Steps;
                    $step->sequence = $i;
                    $step->description = $data["steps"][$i];
                    $recipe->steps()->save($step);              
                }
                //save ingredients
                for($i = 0; $i < count($data["ingredients"]);$i++)
                {
                    $ingredient = new Ingredients;
                    $ingredient->sequence = $i;
                    $ingredient->content = $data["ingredients"][$i];
                    $recipe->ingredients()->save($ingredient);              
                }                
            }
            //remove duplication result by same description
            //just incase the recipe crawler crawler same recipe as we dont fully understand how the api really work
            \DB::delete("delete t1 from recipe t1 inner join recipe t2 where t1.recipe_id != t2.recipe_id and t1.description = t2.description");
            \DB::commit();
        }catch(Exception $e){
            
            return response()->json(["Exception"=>$e]);
        }   
        return response()->json(['success' => $message], $this-> successStatus); 
    }

}
