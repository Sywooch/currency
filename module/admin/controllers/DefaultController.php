<?php

namespace app\module\admin\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
       echo "!!!!" . $this->test(1000);
        return $this->render('index');
    }
    
    public function loadXml()
    {
        $map_url = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=01/01/2016";
        if (($response_xml_data = file_get_contents($map_url))===false){
            echo "Error fetching XML\n";
        } else {
            libxml_use_internal_errors(true);
            $data = simplexml_load_string($response_xml_data);
            if (!$data) {
                echo "Error loading XML\n";
                foreach(libxml_get_errors() as $error) {
                    echo "\t", $error->message;
                }
            } else {
                print_r($data);
            }
        } 
    }
    
    public function test($p_summa)
    {
        $dg_power = 6;
        $result = 0;
        $a_power= [
            [0,NULL          ,NULL           ,NULL            ],  // 1
            [1,"тысяча "     ,"тысячи "      ,"тысяч "        ],  // 2
            [0,"миллион "    ,"миллиона "    ,"миллионов "    ],  // 3
            [0,"миллиард "   ,"миллиарда "   ,"миллиардов "   ],  // 4
            [0,"триллион "   ,"триллиона "   ,"триллионов "   ],  // 5
            [0,"квадриллион ","квадриллиона ","квадриллионов "],  // 6
            [0,"квинтиллион ","квинтиллиона ","квинтиллионов "]   // 7
        ];
        $digit= [
            [[""       ,""       ],"десять "      ,""            ,""          ],
            [["один "  ,"одна "  ],"одиннадцать " ,"десять "     ,"сто "      ],
            [["два "   ,"две "   ],"двенадцать "  ,"двадцать "   ,"двести "   ],
            [["три "   ,"три "   ],"тринадцать "  ,"тридцать "   ,"триста "   ],
            [["четыре ","четыре "],"четырнадцать ","сорок "      ,"четыреста "],
            [["пять "  ,"пять "  ],"пятнадцать "  ,"пятьдесят "  ,"пятьсот "  ],
            [["шесть " ,"шесть " ],"шестнадцать " ,"шестьдесят " ,"шестьсот " ],
            [["семь "  ,"семь "  ],"семнадцать "  ,"семьдесят "  ,"семьсот "  ],
            [["восемь ","восемь "],"восемнадцать ","восемьдесят ","восемьсот "],
            [["девять ","девять "],"девятнадцать ","девяносто "  ,"девятьсот "]
        ];
        if($p_summa == 0) {
            return string("ноль ");
        }
        if($p_summa < 0) { 
            $result="минус "; $p_summa = -$p_summa;
        }
        
        $i = 0;
        $mny = 0;
        $str="";
        $result="";
        $divisor = 1;//делитель
        
        $a_power[0][0]  = 1;
        $a_power[0][1]  = "рубль";
        $a_power[0][2] = "рубля";
        $a_power[0][3] = "рублей";
        
        if($p_summa == 0) return "ноль "+"p_man";
        if($p_summa <  0) {$result="минус "; $p_summa = -$p_summa;}
        
        for($i=0, $divisor=1; $i<$dg_power; $i++) {
            $divisor *= 1000;
        }
        for($i=$dg_power-1; $i>=0; $i--){
                $divisor /= 1000;
                $mny = (int)($p_summa / $divisor);
                $p_summa %= $divisor;
                $str="";
                if($mny==0){
                    if($i>0) continue;
                    $str += $a_power[$i][1];
                }else{
                    if($mny>=100){
                        $str += $digit[$mny/100][4];
                        $mny%=100;
                    }
                    if($mny>=20 ){
                        $str += $digit[$mny/10 ][3];
                        $mny%=10;
                    }
                    if($mny>=10 ) {
                        $str += $digit[$mny-10 ][2];
                    }
                    else if ($mny>=1) {
                        //$str +=$digit[$mny].one[$a_power[$i].[0]];
                        $str +=$digit[$mny][1];
                    }
                    switch($mny){
                        case 1:
                            $str += $a_power[$i][1];
                            break;
                        case 2:
                        case 3:
                        case 4:
                            $str += $a_power[$i][2];
                            break;
                        default:
                            $str += $a_power[$i][3];
                            break;
                    };
                }
                 $result += $str;
          }
          echo $result;
          die;
          return $result;
        
        
    }
    
}
   