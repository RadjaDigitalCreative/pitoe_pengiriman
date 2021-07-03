<?php

use App\Models\Message;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Shipping;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

// use Auth;
class Helper
{
    public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    }

    public static function getAllCategory()
    {
        $category = new Category();
        $menu = $category->getAllParentWithChild();
        return $menu;
    }

    public static function getHeaderCategory()
    {
        $category = new Category();
        // dd($category);
        $menu = $category->getAllParentWithChild();

        if ($menu) {
            ?>

            <li>
                <a href="javascript:void(0);">Kategori<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                    <?php
                    foreach ($menu as $cat_info) {
                        if ($cat_info->child_cat->count() > 0) {
                            ?>
                            <li>
                                <a href="<?php echo route('product-cat', $cat_info->slug); ?>"><?php echo $cat_info->title; ?></a>
                                <ul class="dropdown sub-dropdown border-0 shadow">
                                    <?php
                                    foreach ($cat_info->child_cat as $sub_menu) {
                                        ?>
                                        <li>
                                            <a href="<?php echo route('product-sub-cat', [$cat_info->slug, $sub_menu->slug]); ?>"><?php echo $sub_menu->title; ?></a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li>
                                <a href="<?php echo route('product-cat', $cat_info->slug); ?>"><?php echo $cat_info->title; ?></a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </li>
            <?php
        }
    }

    public static function productCategoryList($option = 'all')
    {
        if ($option = 'all') {
            return Category::orderBy('id', 'DESC')->get();
        }
        return Category::has('products')->orderBy('id', 'DESC')->get();
    }

    public static function postTagList($option = 'all')
    {
        if ($option = 'all') {
            return PostTag::orderBy('id', 'desc')->get();
        }
        return PostTag::has('posts')->orderBy('id', 'desc')->get();
    }

    public static function postCategoryList($option = "all")
    {
        if ($option = 'all') {
            return PostCategory::orderBy('id', 'DESC')->get();
        }
        return PostCategory::has('posts')->orderBy('id', 'DESC')->get();
    }

    // Cart Count
    public static function cartCount($user_id = '')
    {

        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Cart::where('user_id', $user_id)->where('order_id', null)->sum('quantity');
        } else {
            return 0;
        }
    }

    // relationship cart with product

    public static function getAllProductFromCart($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Cart::with('product')->where('user_id', $user_id)->where('order_id', null)->get();
        } else {
            return 0;
        }
    }

    public static function getOrigin($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            $user = DB::table('carts')->join('products', 'carts.product_id', 'products.id')
                ->where('user_id', $user_id)
                ->where('order_id', null)
                ->select('products.location_id')
                ->first();

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://pro.rajaongkir.com/api/city?id=" . $user->location_id . "",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "key: 7b843ff1354c1b7fe1655236ba1faa05"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                }
                $data = json_decode($response, true);
                echo $data['rajaongkir']['results']['city_name'];
        } else {
            return 0;
        }
    }
    public static function getOriginID($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            $user = DB::table('carts')->join('products', 'carts.product_id', 'products.id')
                ->where('user_id', $user_id)
                ->where('order_id', null)
                ->select('products.location_id')
                ->first();


                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://pro.rajaongkir.com/api/city?id=" . $user->location_id . "",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "key: 7b843ff1354c1b7fe1655236ba1faa05"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                }
                $data = json_decode($response, true);
                echo $data['rajaongkir']['results']['city_id'];
        } else {
            return 0;
        }
    }

    public static function getWeight($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            $user = DB::table('carts')->join('products', 'carts.product_id', 'products.id')
                ->where('user_id', $user_id)
                ->where('order_id', null)
                ->select('products.weight', 'carts.quantity')
                ->get();
            $total = 0 ;
            $total_quanitity = 1;
            foreach ($user as $ami) {
                $total_quanitity =  $ami->quantity *= $ami->weight;
                $total += $total_quanitity;
            }
            return $total;
        } else {
            return 0;
        }
    }

    public static function totalCartPrice($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Cart::where('user_id', $user_id)->where('order_id', null)->sum('amount');
        } else {
            return 0;
        }
    }

    // Total amount cart

    public static function wishlistCount($user_id = '')
    {

        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Wishlist::where('user_id', $user_id)->where('cart_id', null)->sum('quantity');
        } else {
            return 0;
        }
    }

    // Wishlist Count

    public static function getAllProductFromWishlist($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Wishlist::with('product')->where('user_id', $user_id)->where('cart_id', null)->get();
        } else {
            return 0;
        }
    }

    public static function totalWishlistPrice($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Wishlist::where('user_id', $user_id)->where('cart_id', null)->sum('amount');
        } else {
            return 0;
        }
    }

    public static function grandPrice($id, $user_id)
    {
        $order = Order::find($id);
        dd($id);
        if ($order) {
            $shipping_price = (float)$order->shipping->price;
            $order_price = self::orderPrice($id, $user_id);
            return number_format((float)($order_price + $shipping_price), 2, '.', '');
        } else {
            return 0;
        }
    }

    // Total price with shipping and coupon

    public static function earningPerMonth()
    {
        $month_data = Order::where('status', 'delivered')->get();
        // return $month_data;
        $price = 0;
        foreach ($month_data as $data) {
            $price = $data->cart_info->sum('price');
        }
        return number_format((float)($price), 2, '.', '');
    }


    // Admin home

    public static function shipping()
    {
        return Shipping::orderBy('id', 'DESC')->get();
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}

?>
