<?php
use App\Enums\GlobalConstant;

if (!function_exists('productImagePath')) {
    function productImagePath(string $type): string
    {
        return asset(GlobalConstant::FILE_PATH['product'][$type]);
    }
}

if (!function_exists('getValidImage$path')) {
    function getValidImage($path, $type = null, $source = null): string
    {

        $givenPath = asset($path);
        if ($source) {
            return is_file($path) ? $givenPath : $source;
        }

        if ($type == 'backend-basic') {
            return is_file($path) ? $givenPath : asset('public/assets/back-end/img/placeholder/placeholder-1-1.png');
        }else if ($type == 'backend-brand') {
            return is_file($path) ? $givenPath : asset('public/assets/back-end/img/placeholder/brand.png');
        }else if ($type == 'backend-banner') {
            return is_file($path) ? $givenPath : asset('public/assets/back-end/img/placeholder/placeholder-4-1.png');
        }else if ($type == 'backend-category') {
            return is_file($path) ? $givenPath : asset('public/assets/back-end/img/placeholder/category.png');
        }else if ($type == 'backend-logo') {
            return is_file($path) ? $givenPath : asset('public/assets/back-end/img/placeholder/placeholder-4-1.png');
        }else if ($type == 'backend-product') {
            return is_file($path) ? $givenPath : asset('public/assets/back-end/img/placeholder/product.png');
        }else if ($type == 'backend-profile') {
            return is_file($path) ? $givenPath : asset('public/assets/back-end/img/placeholder/user.png');
        }else if ($type == 'backend-payment') {
            return is_file($path) ? $givenPath : asset('public/assets/back-end/img/placeholder/placeholder-4-1.png');
        }else if ($type == 'product') {
            if (theme_root_path() == 'theme_aster') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-1-1.png');
            }elseif (theme_root_path() == 'theme_fashion') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-1-1.png');
            }else {
                return is_file($path) ? $givenPath : asset('public/assets/front-end/img/placeholder/placeholder-1-1.png');
            }
        }else if ($type == 'avatar') {
            if (theme_root_path() == 'theme_aster') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/user.png');
            }else if (theme_root_path() == 'theme_fashion') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/user.png');
            }else {
                return is_file($path) ? $givenPath : asset('public/assets/front-end/img/placeholder/user.png');
            }
        }else if ($type == 'banner') {
            if (theme_root_path() == 'theme_aster') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-2-1.png');
            }else if (theme_root_path() == 'theme_fashion') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-2-1.png');
            }else {
                return is_file($path) ? $givenPath : asset('public/assets/front-end/img/placeholder/placeholder-2-1.png');
            }
        }else if ($type == 'wide-banner') {
            if (theme_root_path() == 'theme_aster') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-4-1.png');
            }else if (theme_root_path() == 'theme_fashion') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-4-1.png');
            }else {
                return is_file($path) ? $givenPath : asset('public/assets/front-end/img/placeholder/placeholder-4-1.png');
            }
        }else if ($type == 'brand') {
            if (theme_root_path() == 'theme_aster') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-2-1.png');
            }else if (theme_root_path() == 'theme_fashion') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-2-1.png');
            }else {
                return is_file($path) ? $givenPath : asset('public/assets/front-end/img/placeholder/placeholder-1-1.png');
            }
        }else if ($type == 'category') {
            if (theme_root_path() == 'theme_aster') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-1-1.png');
            }else if (theme_root_path() == 'theme_fashion') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-1-1.png');
            }else {
                return is_file($path) ? $givenPath : asset('public/assets/front-end/img/placeholder/placeholder-1-1.png');
            }
        }else if ($type == 'logo') {
            if (theme_root_path() == 'theme_aster') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-4-1.png');
            }else if (theme_root_path() == 'theme_fashion') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-4-1.png');
            }else {
                return is_file($path) ? $givenPath : asset('public/assets/front-end/img/placeholder/placeholder-4-1.png');
            }
        }else if ($type == 'shop') {
            if (theme_root_path() == 'theme_aster') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/shop.png');
            }else if (theme_root_path() == 'theme_fashion') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/shop.png');
            }else {
                return is_file($path) ? $givenPath : asset('public/assets/front-end/img/placeholder/shop.png');
            }
        }else if ($type == 'shop-banner') {
            if (theme_root_path() == 'theme_aster') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-4-1.png');
            }else if (theme_root_path() == 'theme_fashion') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-4-1.png');
            }else {
                return is_file($path) ? $givenPath : asset('public/assets/front-end/img/placeholder/seller-banner.png');
            }
        }else{
            if (theme_root_path() == 'theme_aster') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-2-1.png');
            }else if (theme_root_path() == 'theme_fashion') {
                return is_file($path) ? $givenPath : theme_asset('assets/img/placeholder/placeholder-2-1.png');
            }else {
                return is_file($path) ? $givenPath : asset('public/assets/front-end/img/placeholder/placeholder-2-1.png');
            }
        }
    }
}
