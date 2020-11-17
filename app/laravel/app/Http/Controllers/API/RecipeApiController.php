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

    public function test(Request $request)
    {
        $ingredients = array("chicken");
        return response()->json(
            Recipe::with(['ingredients','steps'])->whereHas("ingredients",function($query) use ($ingredients){
                foreach($ingredients as $value)
                    $query->where("content",'like',"%$value%");
            })->skip(2)->take(10)->orderBy("skill_term",'desc')->get()
        );
    }
    
    public function getAllRecipe(Request $request)
    {              
        $skip  = $request->input("start",0);
        $take = $request->input("take",5);
        $result = Recipe::skip($skip)->take($take);
        if($request->has("orderBy")){ //order multi order
            $i=0;
            foreach($request->input("orderBy") as $orderBy){
                $result->orderBy($orderBy,$request->input("order")[$i]);
                $i++;
            }
        }
        return response()->json($result->with(['ingredients','steps'])->get());
    }

    //for webcrawler to use only
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
    //detail serach
    public function search(Request $request)
    {
        $query = $request->input();
        $skip  = $request->input("start",0);
        $take = $request->input("take",5);
        //also load ingredients and steps
        $r = Recipe::with(['ingredients','steps']);
        //search by keywords
        $r->where(function($q) use($query){
            foreach($query["keywords"] as $word)
            {
                $q->orWhere("title","like","%$word%");
            }
        });
        //order by statement
        if($request->has("orderBy"))            
            $r->orderByRaw(implode (", ", $query["orderBy"]));
        //cook time statement
        if($query["from"]==$query["to"]){
            if($query["from"]==250)
                $r->where("cook_time",">",$query["from"]*60);
            elseif($query["from"]==10)
                $r->where("cook_time","<",$query["from"]*60);
            else 
                $r->whereBetween("cook_time",[($query["from"]*60)-10,($query["from"]*60)+10]);        
        }else
            $r->whereBetween("cook_time",[($query["from"]*60),($query["to"]*60)]);

        return response()->json([
            "success"      => "success",
            "status code"  =>  $this->successStatus,
            "sql query"    =>  $r->toSql(),
            "query"        =>  $request->input(),            
            //hide the above when finish debug
            "data"         =>  $r->skip($skip)->take($take)->get()
            ]);
    }

    //for search delegate
    public function searchRecipeBykeywords(Request $request)
    {
        $words = $request->input("words");
        $take = $request->input("take",10);
        $result = Recipe::with(['ingredients','steps'])->where("title","like","%$words%");
        return response()->json(
            $result->take($take)->orderByRaw("rating desc","title asc")->get()
        );
    }

    public function ingredientSearch(Request $request)
    {
        $skip  = $request->input("start",0);
        $take = $request->input("take",5);
        $ingredients = $request->input("ingredients",["chicken","wine"]);
        $r = Recipe::with(['ingredients','steps'])->orderBy("rating","desc");//just take first 5 to speed up query time
        $r->whereHas("ingredients",function($query) use($ingredients)
        {              
            $query->select("recipe_id");          
            foreach($ingredients as $ingredient)
            {
                $query->havingRaw("group_concat(content) like \"%$ingredient%\"");
            }
            $query->groupBy("recipe_id");
        });        
        return response()->json([
            'success' => "success",
            "query"=>$r->toSql(),
            "data"=>$r->skip($skip)->take($take)->get(),            
        ]);
    }

    public function updateImage(Request $request){
        $recipe_id = $request->input("recipe_id");
        $new_image = $request->input("new_image");
        $r = Recipe::find($recipe_id);
        $r->image = $new_image;
        //$r->save();
        return response()->json([
            'success' => "success",
            "query"=>$r->image,
            "old_iamge"=>Recipe::find($recipe_id)          
        ]);
    }

    public function getAll(Request $request){
        return response()->json([
            'success' => "success",
            "data"=>Recipe::all('recipe_id','image','resource_url')          
        ]);
    }
}
