<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QrCode;


class QrcodeController extends Controller
{

    //返回PNG格式的图片
    public function index(Request $request)
    {


        QrCode::encoding('utf-8');
        QrCode::format('png');  //Will return a png image

        //默认大小100
        if($request->input('size'))
        {
            QrCode::size($request->input('size'));
        }
        //颜色
        if ($request->input('color') && ($arr = $this->hex2rgb($request->input('color')))) {
            QrCode::color($arr['red'],$arr[green], $arr['bule']);

        }

        //背景颜色
        if ($request->input('bcolor') && ($arr = $this->hex2rgb($request->input('bcolor'))))
        {
            QrCode::backgroundColor($arr['red'],$arr[green], $arr['bule']);

        }
        //渐变颜色
        if ($request->input('scolor')&&$request->input('ecolor'))
        {
            $startArr = $this->hex2rgb($request->input('scolor'));
            $endArr = $this->hex2rgb($request->input('ecolor'));
            $type = $request->input('type',null);

            QrCode::gradient($startArr['red'],$startArr['green'],$startArr['bule'],$endArr['red'],$endArr['green'],$endArr['bule'],$type);
        }
        //边框距离
        if ($request->input('margin'))
        {
            QrCode::margin($request->input('margin'));
        }

        //容错级别
        if ($request->input('error'))
        {
            QrCode::errorCorrection($request->input('error'));
        }

        //添加logo
        if ($request->input('logo'))
        {
            QrCode::merge($request->input('logo'));
        }



        echo QrCode::format('png')->generate("hto");

    }

    public function hex2rgb($colour)
    {
        $colour = '#'.$colour;
        if ($colour[0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
        } elseif (strlen($colour) == 3) {
            list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
        } else {
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array('red' => $r, 'green' => $g, 'blue' => $b);
    }


}


?>
