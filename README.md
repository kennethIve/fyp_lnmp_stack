
# fyp_lnmp_stack

This is my Final yeart project 2020 source code of City University of Hong Kong

Table of Contents

- [Background](#background)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [API Specification](#api-specification)
- [License](#license)

## Background

This project aims to build a Linux Nginx MySQL PHP stack with Laravel framework to be the backend solution for my project. to retrieve recipe data and other custom searching function. 
This repository contains:
1. Laravel app (RestAPIs code)
2. nginx configuration file
3. custom php dokcer file
4. docker-compose.yml

## System Requirements
In this project, I am using a google cloud compute engine as the server to host this project.

OS: **Ubuntu server 18.04**

Installed Software: 
- git
- docker
- docker-compose

Port used (default): 
- 80/443  [for RestAPIs]
- 8081      [for PHP MyAdmin]
- 8080      [for Portainer ]

Please allow **HTTP and HTTPS** and the **required ports** for the GCP compute engine

## Installation

1. git clone this project to your host machine which have a docker installed

``$ git clone https://github.com/kennethIve/fyp_lnmp_stack.git``

2. cd to the **fyp_lnmp_stack** and run the command:

``$ docker-compose up``

3. use Portainer or Command connect php container bash and run the commands inside laravel directory

``$ composer install`` 

``$ php artisan migrate:fresh``

4. Customize the nginx.config and .env file for different port or host

## API Specification
Content-Type: ``application/json``

Authorization: ``token [specified in .env file]``

1. ``[GET] :/api/getRecipes``

<details>
<summary>Request body :</summary>

```json
{

"start":0,

"take":1,

"orderBy":["rating"],

"order":["asc"]

}
```
</details>

<details>
<summary>Response:</summary>

```json
[

{

"recipe_id": 5123,

"title": "Pork & slaw sandwiches",

"description": "Turn your leftovers into something special with these lunchbox-friendly pork baps with tangy mustard",

"image": "https://www.bbcgoodfood.com/sites/default/files/recipe_images/recipe-image-legacy-id--911576_10.jpg",

"rating": 0,

"skill_term": 1,

"cook_time": 780,

"diet_term": "",

"resource_url": "https://www.bbcgoodfood.com/recipes/1959646/pork-and-slaw-sandwiches",

"ingredients": [

{

"recipe_ingredients_id": 52662,

"recipe_id": 5123,

"sequence": 0,

"content": "2 roasted pork shoulder chops (see 'Goes well with...')"

},

{

"recipe_ingredients_id": 52663,

"recipe_id": 5123,

"sequence": 1,

"content": "winter celeriac slaw (see 'Goes well with...')"

},

{

"recipe_ingredients_id": 52664,

"recipe_id": 5123,

"sequence": 2,

"content": "a little wholegrain mustard, for spreading"

},

{

"recipe_ingredients_id": 52665,

"recipe_id": 5123,

"sequence": 3,

"content": "4 burger buns, halved, and toasted if eating at home"

}

],

"steps": [

{

"steps_id": 19127,

"recipe_id": 5123,

"sequence": 0,

"description": "If you’re eating lunch at home, gently heat the meat in a microwave for a few mins, or wrap in foil and bake at 200C/180C fan/gas 6 for 8 mins. If you’re assembling packed lunches, there’s no need to heat. Thinly slice the pork."

},

{

"steps_id": 19128,

"recipe_id": 5123,

"sequence": 1,

"description": "Spread some mustard over the bun bottoms, then add the pork and a heap of slaw. Top with bun tops, wrap and keep cool until lunchtime or eat straight away."

}

]

}

]
```
</details>

2. ``[GET] :/api/getRecipesByName``

<details>
<summary>Request body</summary>

```json
{
    "start":0,
    "take":1,
    "orderBy":["rating"],
    "order":["asc"],
    "words":"chicken with ham"
}
```

</details>
<details>
<summary>Response</summary>

```json
[
    {
        "recipe_id": 6426,
        "title": "Chicken with ham, spinach & pine nuts",
        "description": "A restaurant-style Mediterranean dish of roast chicken breast with stuffing and crème fraîche finished with a white wine sauce",
        "image": "https://www.bbcgoodfood.com/sites/default/files/recipe_images/recipe-image-legacy-id--1021452_11.jpg",
        "rating": 5,
        "skill_term": 2,
        "cook_time": 3000,
        "diet_term": "",
        "resource_url": "https://www.bbcgoodfood.com/recipes/2249648/chicken-with-ham-spinach-and-pine-nuts",
        "ingredients": [],
        "steps": [
            {
                "steps_id": 23451,
                "recipe_id": 6426,
                "sequence": 0,
                "description": "Heat oven to 190C/170C fan/gas 5. Split each chicken breast almost in half and open out like a book. Put each piece of chicken between 2 sheets of cling film and, using a rolling pin, bat out to flatten. Season the chicken all over."
            },
            {
                "steps_id": 23452,
                "recipe_id": 6426,
                "sequence": 1,
                "description": "Put the spinach in a colander and pour over boiling water from the kettle to wilt the leaves. Press out as much water as possible, then tip into a bowl. Add the pine nuts, raisins and spice, season, and mix well to combine. Melt half the butter and add to the bowl."
            },
            {
                "steps_id": 23453,
                "recipe_id": 6426,
                "sequence": 2,
                "description": "Place a slice of ham or prosciutto over each chicken breast and spread with a thin layer of spinach mixture. Roll up and secure with cocktail sticks or string. Heat a knob more of butter and the oil in a pan. Fry the chicken rolls until browned, then remove to a roasting tin and roast for 10-15 mins until cooked through."
            },
            {
                "steps_id": 23454,
                "recipe_id": 6426,
                "sequence": 3,
                "description": "Add the shallots to the pan with the remaining butter and cook gently until softened but not browned. Add the wine and lemon juice, bring to the boil, then simmer until reduced by half."
            },
            {
                "steps_id": 23455,
                "recipe_id": 6426,
                "sequence": 4,
                "description": "Stir in the crème fraîche and simmer for 1-2 mins until thickened. Snip the chives into the sauce and stir lightly. Remove cocktail sticks or string, then slice the chicken and place on warmed plates. Spoon the sauce around and serve with the tians and potatoes."
            }
        ]
    }
]
```
</details>

3. ``[POST]:/api/search``

<details>
<summary>Request body</summary>

```json
{
    "start":0,
    "take":1,
    "from":0,
    "to":240,
    "orderBy":["rating asc"],
    "keywords":["pork"]    
}
```
</details>

<details>
<summary>Response</summary>

```json
{
    "success": "success",
    "status code": 200,
    "sql query": "select * from `recipe` where (`title` like ?) and `cook_time` between ? and ? order by rating asc",
    "query": {
        "start": 0,
        "take": 1,
        "from": 0,
        "to": 240,
        "orderBy": [
            "rating asc"
        ],
        "keywords": [
            "pork"
        ]
    },
    "data": [
        {
            "recipe_id": 5123,
            "title": "Pork & slaw sandwiches",
            "description": "Turn your leftovers into something special with these lunchbox-friendly pork baps with tangy mustard",
            "image": "https://www.bbcgoodfood.com/sites/default/files/recipe_images/recipe-image-legacy-id--911576_10.jpg",
            "rating": 0,
            "skill_term": 1,
            "cook_time": 780,
            "diet_term": "",
            "resource_url": "https://www.bbcgoodfood.com/recipes/1959646/pork-and-slaw-sandwiches",
            "ingredients": [
                {
                    "recipe_ingredients_id": 52662,
                    "recipe_id": 5123,
                    "sequence": 0,
                    "content": "2 roasted pork shoulder chops (see 'Goes well with...')"
                },
                {
                    "recipe_ingredients_id": 52663,
                    "recipe_id": 5123,
                    "sequence": 1,
                    "content": "winter celeriac slaw (see 'Goes well with...')"
                },
                {
                    "recipe_ingredients_id": 52664,
                    "recipe_id": 5123,
                    "sequence": 2,
                    "content": "a little wholegrain mustard, for spreading"
                },
                {
                    "recipe_ingredients_id": 52665,
                    "recipe_id": 5123,
                    "sequence": 3,
                    "content": "4 burger buns, halved, and toasted if eating at home"
                }
            ],
            "steps": [
                {
                    "steps_id": 19127,
                    "recipe_id": 5123,
                    "sequence": 0,
                    "description": "If you’re eating lunch at home, gently heat the meat in a microwave for a few mins, or wrap in foil and bake at 200C/180C fan/gas 6 for 8 mins. If you’re assembling packed lunches, there’s no need to heat. Thinly slice the pork."
                },
                {
                    "steps_id": 19128,
                    "recipe_id": 5123,
                    "sequence": 1,
                    "description": "Spread some mustard over the bun bottoms, then add the pork and a heap of slaw. Top with bun tops, wrap and keep cool until lunchtime or eat straight away."
                }
            ]
        }
    ]
}
```

</details>

4. ``[POST]:/api/ingredientSearch``

<details>
<summary>Request body</summary>

```json
{
    "start":0,
    "take":1,
    "from":0,
    "to":240,
    "orderBy":["rating asc"],    
    "ingredients":["chicken","wine","2 tsp olive oil","peas"]
}
```
</details>

<details>
<summary>Response</summary>

```json
{
    "success": "success",
    "query": "select * from `recipe` where exists (select `recipe_id` from `recipe_ingredients` where `recipe`.`recipe_id` = `recipe_ingredients`.`recipe_id` group by `recipe_id` having group_concat(content) like \"%chicken%\" and group_concat(content) like \"%wine%\" and group_concat(content) like \"%2 tsp olive oil%\" and group_concat(content) like \"%peas%\") order by `rating` desc",
    "data": [
        {
            "recipe_id": 281,
            "title": "Parmesan spring chicken",
            "description": "Full of spring flavours, the Parmesan coating gives a satisfying crunch and the meat stays tender",
            "image": "https://www.bbcgoodfood.com/sites/default/files/recipe_images/recipe-image-legacy-id--327529_11.jpg",
            "rating": 5,
            "skill_term": 1,
            "cook_time": 1200,
            "diet_term": "",
            "resource_url": "https://www.bbcgoodfood.com/recipes/5987/parmesan-spring-chicken",
            "ingredients": [
                {
                    "recipe_ingredients_id": 2811,
                    "recipe_id": 281,
                    "sequence": 0,
                    "content": "1 egg white"
                },
                {
                    "recipe_ingredients_id": 2812,
                    "recipe_id": 281,
                    "sequence": 1,
                    "content": "5 tbsp finely grated parmesan"
                },
                {
                    "recipe_ingredients_id": 2813,
                    "recipe_id": 281,
                    "sequence": 2,
                    "content": "4 boneless, skinless chicken breasts"
                },
                {
                    "recipe_ingredients_id": 2814,
                    "recipe_id": 281,
                    "sequence": 3,
                    "content": "400g new potatoes, cut into small cubes"
                },
                {
                    "recipe_ingredients_id": 2815,
                    "recipe_id": 281,
                    "sequence": 4,
                    "content": "140g frozen peas"
                },
                {
                    "recipe_ingredients_id": 2816,
                    "recipe_id": 281,
                    "sequence": 5,
                    "content": "good handful baby spinach leaves"
                },
                {
                    "recipe_ingredients_id": 2817,
                    "recipe_id": 281,
                    "sequence": 6,
                    "content": "1 tbsp white wine vinegar"
                },
                {
                    "recipe_ingredients_id": 2818,
                    "recipe_id": 281,
                    "sequence": 7,
                    "content": "2 tsp olive oil"
                }
            ],
            "steps": [
                {
                    "steps_id": 1524,
                    "recipe_id": 281,
                    "sequence": 0,
                    "description": "Heat grill to medium and line the grill pan with foil. Beat the egg white on a plate with a little salt and pepper. Tip the parmesan onto another plate. Dip the chicken first in egg white, then in the cheese. Grill the coated chicken for 10-12 mins, turning once until browned and crisp."
                },
                {
                    "steps_id": 1525,
                    "recipe_id": 281,
                    "sequence": 1,
                    "description": "Meanwhile, boil the potatoes for 10 mins, adding the peas for the final 3 mins, then drain. Toss the vegetables with the spinach leaves, vinegar, oil and seasoning to taste. Divide between four warm plates, then serve with the chicken."
                }
            ]
        }
    ]
}
```

</details>

## License

[Academic Free License v3.0](afl-3.0) © Kenneth Huang
