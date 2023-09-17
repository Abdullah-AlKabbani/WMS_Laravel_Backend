<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Import;
use App\Models\Export;
use App\Models\Lost;
use App\Models\Category;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\lowStockNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use PhpParser\Node\Expr\Cast\String_;

class InventoryController extends Controller
{

    public function product(Request $request)
    {


        /* try{ $request->validate([

             "products.*.product"=>"required|string",
             "products.*.siz"=>"required|integer|min:0"
           ]);
          }
          catch(Exception $exc)
          {
            return $exc->getMessage();
          }
           $products = $request->products;
           foreach ($request->input($products,[] )as $product) {
             $inventory = new Inventory();
             $inventory->user_id= auth()->user()->id;
             $inventory->product =  $product['product'];
             $inventory->siz =  $product['siz'];
             $inventory->save();
           }

           return response()->json([
            "status"=>200,
            "message"=>"products created successfully ",

           ]);*/

           $request->validate([
            "product" => "required",
            "type" => "required"
        ]);

        $inventory = new Inventory();
        $inventory->user_id = auth()->user()->id;
        $inventory->product =  $request->product;
        $inventory->siz =  $request->siz;
        $inventory->colore =  $request->colore;
        $type =  $request->type;
        $category = Category::where('type', $type )->first();
        $category_id = $category['id'];
        $inventory->category_id =  $category_id;

        $inventory->save();

        return response()->json([
            "message" => "product created successfully ",

        ], 200);
    }

    public function edit_siz(Request $request)
    {
        try {
            $request->validate([
                "product" => "required|string",
                "new_siz" => "required|integer"
            ]);
        } catch (Exception $exc) {
            return $exc->getMessage();
        }

        $name = $request->product;
        $siz =  $request->new_siz;

        $product = inventory::where([
            'product' => $name,
            'user_id' => auth()->user()->id
        ])->first();

        if ($product == null) {
            return response()->json([
                "message" => "product was not found",

            ]);
        }
        $amount =  $product['amount'];
        if($siz >=  $amount){
        $product->siz =$siz;
        $product->save();
      
        $n1 =  "siz edited successfully";
        $mergedString = implode(" : ", [$name, $n1]);
        return response()->json([
            "message"=>  $mergedString
        ], 200);
     }
     else{
       
        $n1 =  "please enter bigger size";
        $mergedString = implode(" : ", [$name, $n1]);
        return response()->json([
            "message"=>  $mergedString
        ], 201);;
     }

    }



    public function review(Request $request,$method)
    {

        if($method== "Recent Quantity"){
        $naw = Inventory::where('user_id', auth()->user()->id)
            ->select('product', 'amount', 'siz')->get();
        if ($naw->isEmpty()) {
            return response()->json([
                "movement" => "no products in inventory",

            ], 201);
        }
        return response()->json([
            "movement" => $naw,
        ], 200);
      }

      else if($method== "Import"){

        $datestr1 =  $request->date1;
        $datestr2 =  $request->date2;

        if ($datestr2 == null &&  $datestr1 != null) {

            $date1 =  Carbon::parse($datestr1)->format('Y-m-d');
            $product = Import::where([
                'user_id' => auth()->user()->id,
                'date' => $date1
            ])->get();
        } else if ($datestr1 == null  &&  $datestr2 != null) {
            $date2 =  Carbon::parse($datestr2)->format('Y-m-d');
            $product = Import::where([
                'user_id' => auth()->user()->id,
                'date' => $date2
            ])->get();
        } else if ($datestr1 == null  &&  $datestr2 == null) {
            return response()->json([

                "movement" => "please inter date ",

            ], 202);
        } else {
            $date1 =  Carbon::parse($datestr1)->format('Y-m-d');
            $date2 =  Carbon::parse($datestr2)->format('Y-m-d');

            $product = Import::where('user_id', auth()->user()->id,)
                ->whereBetween('date', [$date1, $date2])->select('product', 'amount', 'date')->get();
        }

        if ($product->isEmpty()) {
            return response()->json([

                "movement" => "no products were imported during this date ",

            ], 201);
        }

        return response()->json([

            "movement" => $product,

        ], 200);

      }

      else if($method== "Export"){

        $datestr1 =  $request->date1;
        $datestr2 =  $request->date2;

        if ($datestr2 == null &&  $datestr1 != null) {

            $date1 =  Carbon::parse($datestr1)->format('Y-m-d');
            $product = Export::where([
                'user_id' => auth()->user()->id,
                'date' => $date1
            ])->get();
        } else if ($datestr1 == null  &&  $datestr2 != null) {
            $date2 =  Carbon::parse($datestr2)->format('Y-m-d');
            $product = Export::where([
                'user_id' => auth()->user()->id,
                'date' => $date2
            ])->get();
        } else if ($datestr1 == null  &&  $datestr2 == null) {
            return response()->json([

                "movement" => "please inter date ",

            ],202);

        } else {
            $date1 =  Carbon::parse($datestr1)->format('Y-m-d');
            $date2 =  Carbon::parse($datestr2)->format('Y-m-d');

            $product = Export::where('user_id', auth()->user()->id,)
                ->whereBetween('date', [$date1, $date2])->select('product', 'amount', 'date')->get();
        }

        if ($product->isEmpty()) {
            return response()->json([
                "movement" => "no products were exported during this date ",
            ],201);
        }

        return response()->json([

            "movement" => $product,

        ],200);
      }


      else if($method== "Corrupted"){


        $datestr1 =  $request->date1;
        $datestr2 =  $request->date2;



        if ($datestr2 == null &&  $datestr1 != null) {

            $date1 =  Carbon::parse($datestr1)->format('Y-m-d');
            $product = Lost::where([
                'user_id' => auth()->user()->id,
                'date' => $date1
            ])->get();
        } else if ($datestr1 == null  &&  $datestr2 != null) {
            $date2 =  Carbon::parse($datestr2)->format('Y-m-d');
            $product = Lost::where([
                'user_id' => auth()->user()->id,
                'date' => $date2
            ])->get();
        } else if ($datestr1 == null  &&  $datestr2 == null) {
            return response()->json([
                "movement" => "please inter date ",
            ],202);
        } else {
            $date1 =  Carbon::parse($datestr1)->format('Y-m-d');
            $date2 =  Carbon::parse($datestr2)->format('Y-m-d');

            $product = Lost::where('user_id', auth()->user()->id,)
                ->whereBetween('date', [$date1, $date2])->select('product', 'amount', 'cause', 'date')->get();
        }

        if ($product->isEmpty()) {
            return response()->json([
                "movement" => "no products were losted during this date ",
            ],201);
        }

        return response()->json([
            "movement" => $product,
        ],200);
      }

    }

    /*
    public function dateImport(Request $request)
    {

        $datestr1 =  $request->date1;
        $datestr2 =  $request->date2;



        if ($datestr2 == null &&  $datestr1 != null) {

            $date1 =  Carbon::parse($datestr1)->format('Y-m-d');
            $product = Import::where([
                'user_id' => auth()->user()->id,
                'date' => $date1
            ])->get();
        } elseif ($datestr1 == null  &&  $datestr2 != null) {
            $date2 =  Carbon::parse($datestr2)->format('Y-m-d');
            $product = Import::where([
                'user_id' => auth()->user()->id,
                'date' => $date2
            ])->get();
        } elseif ($datestr1 == null  &&  $datestr2 == null) {
            return response()->json([
                "message" => "please inter date ",
            ], 201);
        } else {
            $date1 =  Carbon::parse($datestr1)->format('Y-m-d');
            $date2 =  Carbon::parse($datestr2)->format('Y-m-d');

            $product = Import::where('user_id', auth()->user()->id,)
                ->whereBetween('date', [$date1, $date2])->get();
        }

        if ($product->isEmpty()) {
            return response()->json([

                "message" => "no products were imported during this date ",
            ], 202);
        }

        return response()->json([

            "import in this date" => $product,

        ], 200);
    }

    public function dateExport(Request $request)
    {

        $datestr1 =  $request->date1;
        $datestr2 =  $request->date2;



        if ($datestr2 == null &&  $datestr1 != null) {

            $date1 =  Carbon::parse($datestr1)->format('Y-m-d');
            $product = Export::where([
                'user_id' => auth()->user()->id,
                'date' => $date1
            ])->get();
        } elseif ($datestr1 == null  &&  $datestr2 != null) {
            $date2 =  Carbon::parse($datestr2)->format('Y-m-d');
            $product = Export::where([
                'user_id' => auth()->user()->id,
                'date' => $date2
            ])->get();
        } elseif ($datestr1 == null  &&  $datestr2 == null) {
            return response()->json([
                "status" => 200,
                "message" => "please inter date ",
            ]);
        } else {
            $date1 =  Carbon::parse($datestr1)->format('Y-m-d');
            $date2 =  Carbon::parse($datestr2)->format('Y-m-d');

            $product = Export::where('user_id', auth()->user()->id,)
                ->whereBetween('date', [$date1, $date2])->get();
        }

        if ($product->isEmpty()) {
            return response()->json([
                "status" => 200,
                "message" => "no products were exported during this date ",
            ]);
        }

        return response()->json([
            "status" => 200,
            "export in this date" => $product,

        ]);
    }

    public function dateLost(Request $request)
    {

        $datestr1 =  $request->date1;
        $datestr2 =  $request->date2;



        if ($datestr2 == null &&  $datestr1 != null) {

            $date1 =  Carbon::parse($datestr1)->format('Y-m-d');
            $product = Lost::where([
                'user_id' => auth()->user()->id,
                'date' => $date1
            ])->get();
        } elseif ($datestr1 == null  &&  $datestr2 != null) {
            $date2 =  Carbon::parse($datestr2)->format('Y-m-d');
            $product = Lost::where([
                'user_id' => auth()->user()->id,
                'date' => $date2
            ])->get();
        } elseif ($datestr1 == null  &&  $datestr2 == null) {
            return response()->json([
                "status" => 200,
                "message" => "please inter date ",
            ]);
        } else {
            $date1 =  Carbon::parse($datestr1)->format('Y-m-d');
            $date2 =  Carbon::parse($datestr2)->format('Y-m-d');

            $product = Lost::where('user_id', auth()->user()->id,)
                ->whereBetween('date', [$date1, $date2])->get();
        }

        if ($product->isEmpty()) {
            return response()->json([
                "status" => 200,
                "message" => "no products were losted during this date ",
            ]);
        }

        return response()->json([
            "status" => 200,
            "lost in this date" => $product,

        ]);
    }
    */

     public function lostIn(Request $request)
    {
        $user = auth()->user();
        try {
            $request->validate([
                "lost" => "required|integer",
                "date" => "required|string"
            ]);
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
        $product =  $request->product;
        $lostn =  $request->lost;
        $datestr =  $request->date;
        $date =  Carbon::parse($datestr)->format('Y-m-d');
        $cause =  $request->cause;

        $inventory = Inventory::where([
            'user_id' => auth()->user()->id,
            'product' => $product
        ])->first();
        if ($inventory == null) {
            return response()->json([

                "message" => "this product was not found ",

            ],202);
        }
        $amount =  $inventory['amount'];


        if ($lostn <=  $amount) {

            $lost = new Lost();

            $lost->user_id = auth()->user()->id;
            $lost->product = $product;
            $lost->amount = $lostn;
            $lost->date =  $date;
            $lost->cause =  $cause;
            $lost->save();

            $inventory->update(['amount' => $amount -  $lostn]);
            $inventory->save();
            if ($inventory->amount < 200) {
                Notification::send($user, new lowStockNotification($inventory->product));
            }
            $n1 =  "corrupted product extract successfully";
                $mergedString = implode(" : ", [$product, $n1]);
                return response()->json([
                    "message"=>  $mergedString
                ], 200);

        } else {
            $n1 =  "you dont have enough amount";
            $mergedString = implode(" : ", [$product, $n1]);
            return response()->json([
                "message"=>  $mergedString
            ], 201);

        }
    }

    public function import(Request $request)
    {

        try {
            $request->validate([
                "product" => "required",
                "import" => "required|integer",
                "date" => "required"
            ]);
        } catch (Exception $exc) {
            return $exc->getMessage();
        }


        $datestr =  $request->date;

     //  $date = Carbon::createFromFormat('Y-m-s H:i:s', $datestr)->format('Y/m/d');
        $date =  Carbon::parse($datestr)->format('Y-m-d');

            $product =  $request->product;
            $importn = $request->import;


            $inventory = Inventory::where([
                'user_id' => auth()->user()->id,
                'product' => $product
            ])->first();

            if ($inventory == null) {
                return response()->json([
                    "message" => "this product was not found ",

                ]);
            }
            // $inventory = $inventory[0];
            $amount =  $inventory['amount'];
            $siz =  $inventory['siz'];

            if ($importn <= $siz - $amount) {

                $import = new Import();

                $import->user_id = auth()->user()->id;
                $import->product = $product;
                $import->amount = $importn;
                $import->amountOld = $importn;
                $import->date =  $date;
                $import->save();

                $inventory->update(['amount' => $amount + $importn]);
                $inventory->save();

                $n1 =  "import added successfully";
                $mergedString = implode(" : ", [$product, $n1]);
                return response()->json([
                    "message"=>  $mergedString
                ], 200);

            } else {
                $message = "you can import only";
                $n =  $siz - $amount;
                $n1 = strval( $n );
                $mergedString = implode(" : ", [$product,$message,$n1]);

                return response()->json([
                    "message"=> $mergedString ,
                ], 201);
            }


    }



    public function export(Request $request, $method)
    {
        $user = auth()->user();
        try {
            $request->validate([

                "product" => "required",
                "export" => "required|integer",
                "date" => "required"
            ]);
        } catch (Exception $exc) {
            return $exc->getMessage();
        }



           $datestr =  $request->date;
            $date =  Carbon::parse($datestr)->format('Y-m-d');

            $product =$request->product;
            $exportn = $request->export;


            $inventory = Inventory::where([
                'user_id' => auth()->user()->id,
                'product' => $product
            ])->first();
            if ($inventory == null) {
                return response()->json([
                    "status" => 200,
                    "message" => "this product was not found ",

                ]);
            }
            $amount =  $inventory['amount'];


            if ($exportn <=  $amount) {

                $export = new export();

                $export->user_id = auth()->user()->id;
                $export->product = $product;
                $export->amount = $exportn;
                $export->date =  $date;
                $export->save();

                $inventory->update(['amount' => $amount -  $exportn]);
                $inventory->save();

                if ($inventory->amount < 200) {
                    Notification::send($user, new lowStockNotification($inventory->product));
                }

                while ($exportn != 0) {

                    if ($method == "(FIFO) First In First Out") {
                        $old = Import::where([
                            'user_id' => auth()->user()->id,
                            'product' => $product
                        ])->where('amountOld', '!=', 0)->orderBy('date', 'asc')->first();
                    } elseif ($method == "(LIFO) Last In First Out") {
                        $old = Import::where([
                            'user_id' => auth()->user()->id,
                            'product' => $product
                        ])->where('amountOld', '!=', 0)->orderBy('date', 'desc')->first();
                    } elseif ($method == "Random") {
                        $old = Import::where([
                            'user_id' => auth()->user()->id,
                            'product' => $product
                        ])->where('amountOld', '!=', 0)->inRandomOrder()->first();
                    }
                    $amountOld =  $old['amountOld'];

                    if ($amountOld >= $exportn) {

                        $old->update(['amountOld' => $amountOld -  $exportn]);
                        $old->save();
                        $exportn = 0;
                    } else {

                        $old->update(['amountOld' => 0]);
                        $old->save();
                        $exportn = $exportn - $amountOld;

                    }
                }

              
                $n1 =  "Export added successfully";
                $mergedString = implode(" : ", [$product, $n1]);
                return response()->json([
                    "message"=>  $mergedString
                ], 200);

            } else {

                $message = "you can export only";
                $n = $amount;
                $n1 = strval( $n );
                $mergedString = implode(" : ", [$product,$message,$n1]);

                return response()->json([
                    "message"=> $mergedString ,
                ], 201);

            }



    }


    public function inventory(Request $request,)
    {
        try {
            $request->validate([
                "inventory" => "required|integer"
            ]);
        } catch (Exception $exc) {
            $exc->getMessage();
        }
        $product =  $request->product;
        $env =  $request->inventory;

        $inventory = Inventory::where([
            'user_id' => auth()->user()->id,
            'product' => $product
        ])->first();
        if ($inventory == null) {
            return response()->json([

                "message" => "prduct are not found "
            ], 203);
        }
        $amount =  $inventory['amount'];

        if ($amount == $env) {
            $n1 =  "there is no differencess";
            $mergedString = implode(" : ", [$product, $n1]);
            return response()->json([
                "message"=>  $mergedString
            ], 200);

        } elseif ($amount < $env) {

            $message = "you have an increase";
                $n = $env - $amount;
                $n1 = strval( $n );
                $mergedString = implode(" : ", [$product,$message,$n1]);


                return response()->json([
                    "message"=> $mergedString ,
                ], 201);
        } else {
            $message = "you have an decrease";
            $n =  $amount - $env;
            $n1 = strval( $n );
            $mergedString = implode(" : ", [$product,$message,$n1]);

            return response()->json([
                "message"=> $mergedString ,
            ], 202);
    }

    }

    public function cost(Request $request)
    {

        $product = $request->product;
        $price = $request->price;


        $inventory = Inventory::where([
            'user_id' => auth()->user()->id,
            'product' => $product
        ])->first();

        $amount =  $inventory['amount'];
        $cost =  $amount * $price;

        $message = "Product's total price is";
        $n1 = strval( $cost );
        $mergedString = implode(" : ", [$product,$message,$n1]);


        return response()->json([
            "message"=> $mergedString ,
            "Price"=> $cost
        ], 200);
    }

    public function product_count(){

        $count = Inventory::where('user_id', auth()->user()->id,)->count();
       
        return response()->json([
            "num_products" =>  $count
        ],200);


    }


    public function product_name(){

        $name = Inventory::where('user_id', auth()->user()->id)->pluck('product')->toArray();


        return response()->json([
            "name_products" =>  $name
        ],200);


    }

    public function add_employee(Request $request){


        try {
            $request->validate([
             "name"=>"required",
             "email"=>"required",
             "phone_n"=>"required"
            ]);
        } catch (Exception $exc) {
            return $exc->getMessage();
        }

        $employee = new Employee();

        $employee->user_id = auth()->user()->id;
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone_n = $request->phone_n;

        $employee->save();

        return response()->json([
            "status" => 200,
            "messag" => "employee added successfully"
        ],200);

    }
    public function create_backup()
    {
        Artisan::call('command:dbbackup');
        return response()->json([
            "status"=>200,
            "message"=> "backup was successful"
        ]);
    }
    public function restore_database()
    {
        Artisan::call('command:restoredb');
        return response()->json([
            "status"=>200,
            "message"=> "restore was successful"
        ]);
    }


}
