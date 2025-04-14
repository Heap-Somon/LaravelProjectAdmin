<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


class Homecontroller extends Controller
{
    public function Home(){
        return view('dashboard.home');
    }

    public function logo(){
        return view('dashboard.Logo.add');
    }

    public function submitAddLogo(Request $request){
        $validate = Validator::make($request->all(),[
            'thumbnail' => 'required|mimes:jpg,jpeg,png' 
        ]);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate);
        }
        $thumbnail = $request->file('thumbnail');
        $nameFile = time() ."-". $thumbnail->getClientOriginalName();
        $path = "./image";
        $thumbnail->move($path,$nameFile);

        $addLogo = DB::table('logos')->insert([
            'thumbnail' => $nameFile
        ]);

        if($addLogo){
            return redirect()->back()->with('success','Logo Upload Successful');
        }
    }

    public function listLogo(){
        $show = DB::table('logos')->get();
        // return view("modelCar.update",["data"=>$recieveData]);
        return view('dashboard.Logo.list',["datas"=>$show]);
    }

    public function destroy($id){
        $result = DB::table('logos')->where('id',$id)->delete();
        if($result){
            return response()->json([
                'success' => 'Deleted Success'
            ]);
        }
    }

    public function updateLogo($id){
        $data = DB::table('logos')->where('id',$id)->get();
        return view('dashboard.Logo.update',compact('data'));
    }
    public function submitUpdateLogo(Request $request){
        if($request->hasFile('newthumbnail')){
            $thumbnail = $request->file('newthumbnail');
            $nameFile = time() ."-". $thumbnail->getClientOriginalName();
            $path = "./image";
            $thumbnail->move($path,$nameFile);
        }
        else{
            $nameFile = $request-> oldthumbnail;
        }
        $update = DB::table('logos')
                ->where('id',$request->id)
                ->update([
                    'thumbnail' => $nameFile
                ]);
                // dd($thumbnail);
        if($update){
            return redirect()->route('list-logo')->with('success','Update Logo Successfull');
        }
        
    }

    public function category(){
        return view('dashboard.category.add');
    }
    public function addCategory(Request $request){
        $validate = Validator::make($request->all(),[
            'category_name' => 'required|string|max:30'
        ]);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate);
        }
        $result = DB::table('categories')->insert([
            'name' => $request->category_name
        ]);
        if($result){
            return redirect()->back();
        }
    }

    public function listCategory(){
        $category = DB::table('categories')->get();
        return view('dashboard.category.list',compact('category'));
    }
    public function updateCategory($id){
        $update = DB::table('categories')->where('id',$id)->get();
        return view('dashboard.category.update',compact('update'));
    }

    public function submitUpdateCategory(Request $request){
        $validate = Validator::make($request->all(),[
            'category_name' => 'required|string|max:30'
        ]);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate);
        }
        $result = DB::table('categories')->where('id',$request->id)->update([
            'name' => $request->category_name
        ]);
        if($result){
            return redirect()->route('list-category')->with('success','Update Category Successful');
        }
    }
    public function destroyCategory($id){
        $result = DB::table('categories')->where('id',$id)->delete();
        if($result){
            return response()->json([
                'success' => 'Deleted Success'
            ]);
        }
    }

    //Product
    public function product(){
        $products = DB::table('products as p')
                ->join('categories as c','p.category_id','=','c.id')
                ->select(
                    'p.*',
                    'c.name as category_name'
                )
                ->get();
        return view('dashboard.product.list',compact('products'));
    }
    public function addProduct(){
        $category = DB::table('categories')->get();
        return view('dashboard.product.add',compact('category'));
    }
    public function submitAddProduct(Request $request){
        // Debugging: See what data is received
        // dd($request->all());

        $validates = validator::make($request->all(),[
            'name'=> 'required|string|max:20',
            'qty'=> 'required',
            'regular_price'=>'required',
            'sale_price'=>'required',
            'size'=>'required|array',
            'size.*'=>'string',
            'color'=>'required|array',
            'color.*'=>'string',
            'category'=>'required',
            'thumbnail'=>'required|mimes:jpg,jpeg,png',
            'description'=>'required'
        ]);
        if($validates->fails()){
            return redirect()->back()->withErrors($validates);
        }

        $thumbnail = $request->file('thumbnail');
        $filename = time()."-".$thumbnail->getClientOriginalName();
        $path ='C:\xampp\htdocs\products';
        $thumbnail->move($path, $filename);
        // $validates->validate();
        
        //If we want to store array data we must convert array to string. There are 2 way:
        //Convert to string
        // $validateData = $validates->validate();

        // $sizeString = implode(', ',$validateData['size']);
        // $colorString = implode(', ',$validateData['color']);
        //Convert via json
        $sizeString = json_encode($request -> size);
        $colorString = json_encode($request -> color);
        $result = DB::table('products')->insert([
            'name' => $request->name,
            'qty' => $request->qty,
            'regular_price' => $request -> regular_price,
            'sale_price' => $request -> sale_price,
            // How to convert array to string
            // 'color' => implode(',',$request -> color),
            'thumbnail' => $filename,
            'category_id' => $request-> category,
            'color'=> $colorString,
            'size'=>$sizeString,
            'description'=> $request->description,
            'viewers' => 0
        ]);

        if($result){
            return redirect()->route('list')->with('success','Add product successful');
        }
    }

    public function updateProduct($id,Request $request){
        $showCate = DB::table('categories')->get();
        $show = DB::table('products')
        ->where('id',$id)
        ->get();
        return view('dashboard.product.update',compact('show','showCate'));
    }
    public function submitUpdateProduct(Request $request){
        if($request->hasFile('thumbnail')){
            $thumbnail = $request->file('thumbnail');
            $namefile = time()."-". $thumbnail->getClientOriginalName();
            $path ='C:\xampp\htdocs\products';
            $thumbnail -> move($path,$namefile);
        }
        else{
            $namefile = $request-> oldThumbnail;
        }
        //How to convert array to string
        $sizeString = json_encode($request -> size);
        $colorString = json_encode($request -> color);
        $update = DB::table('products')->where('id',$request->id)->update([
            'name' => $request->name,
            'qty' => $request->qty,
            'regular_price' => $request -> regular_price,
            'sale_price' => $request -> sale_price,
            // How to convert array to string
            // 'color' => implode(',',$request -> color),
            'thumbnail' => $namefile,
            'category_id' => $request-> category,
            'color'=> $colorString,
            'size'=>$sizeString,
            'description'=> $request->description,
            'viewers' => 0
        ]);
        if($update){
            return redirect()->route('list')->with('success','Update product successful');
        }
    }
    public function destroyProduct($id){
        $result = DB::table('products')->where('id',$id)->delete();
        if($result){
            return response()->json([
                'success' => 'Deleted Success'
            ]);
        }
    }

    //News
    public function news(){
        return view('dashboard.news.add');
    }
    public function submitAddNews(Request $request){
        $validate = Validator::make($request->all(),[
            'title'=> 'required|string|max:100',
            'thumbnail' => 'required|mimes:jpg,jpeg,png',
            'description'=>'required'
        ]);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate);
        }
        $thumbnail = $request->file('thumbnail');
        $filename = time()."-".$thumbnail->getClientOriginalName();
        $path ='C:\xampp\htdocs\products';
        $thumbnail->move($path, $filename);

        $addLogo = DB::table('news')->insert([
            'description'=> $request->description,
            'viewers' => 0,
            'title' => $request->title,
            'banner' => $filename,
            'thumbnail' => $filename
        ]);

        if($addLogo){
            return redirect()->route('list-news')->with('success','Logo Upload Successful');
        }
    }
    public function listNews(){
        $news = DB::table('news')->get();
        return view('dashboard.news.list',compact('news'));
    }
    public function updateNews($id,Request $request){
        $showNew = DB::table('news')->get();
        $show = DB::table('news')
        ->where('id',$id)
        ->get();
        return view('dashboard.News.update',compact('show','showNew'));
    }
    public function submitUpdateNews(Request $request){
        if($request->hasFile('thumbnail')){
            $thumbnail = $request->file('thumbnail');
            $namefile = time()."-". $thumbnail->getClientOriginalName();
            $path ='C:\xampp\htdocs\products';
            $thumbnail -> move($path,$namefile);
        }
        else{
            $namefile = $request-> OldThumbnail;
        }
        $update = DB::table('news')->where('id',$request->id)->update([
            'title' => $request->title,
            'description'=> $request->description,
            'banner' => $namefile,
            'thumbnail' => $namefile,
            'viewers' => 0
        ]);
        if($update){
            return redirect()->route('list-news')->with('success','Update product successful');
        }
    }
    public function destroyNews($id){
        $result = DB::table('news')->where('id',$id)->delete();
        if($result){
            return response()->json([
                'success' => 'Deleted Success'
            ]);
        }
    }
}
