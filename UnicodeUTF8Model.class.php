<?php
namespace Home\Model;
/**
 * Created by sublime.
 * User: zzz
 * Date: 2021年04月21日14:13:49
 * desc: unicode/utf8转换 UnicodeUTF8
 */
class UnicodeUTF8Model{
    
    /**
     * [utf8ToUnicode utf8 转换为 unicode]
     * @author zzz
     * @DateTime 2021-04-21T14:27:25+0800
     */
    public function utf8ToUnicode($raw_string){
        while (!empty($raw_string)) {
            #字符串第一个字节的字节数
            $first_character_byte_num = $this->returnCharacterByteNum($raw_string);
            #第一个字符
            $character   = substr($raw_string, 0, $first_character_byte_num);
            #剩余的字符
            $raw_string  = substr($raw_string, $first_character_byte_num);
            #第一个字符的unicode序号
            $unicode     = $this->characterToUnicode($character);
            #第一个字符的unicode 十六进制
            $unicode_hex = dechex($unicode);
            $unicode_hex = '\u'. $this->hexAddZero($unicode_hex);

            #第一个字符的信息
            $info = compact('character', 'unicode', 'unicode_hex');
            $res[] = $info;
        }
        return $res;
    }

    /**
     * [hexAddZero 十六进制补0]
     * @author zzz
     * @DateTime 2021-04-21T15:03:34+0800
     */
    public function hexAddZero($num){
        if(strlen($num) == 1) return '000'. $num;
        if(strlen($num) == 2) return '00'. $num;
        if(strlen($num) == 3) return '0'. $num;
        return $num;
    }

    /**
     * [characterToUnicode 单个utf8 字符转换为 unicode]
     * @author zzz
     * @DateTime 2021-04-21T14:36:06+0800
     */
    public function characterToUnicode($character){
        #取表情的第一个字节
        $character_first = ord($character[0]);
        if ($character_first >=0 && $character_first <= 127){
            return $character_first;    
        }

        #取表情的第二个字节
        $character_second = ord($character[1]);
        if ($character_first >= 192 && $character_first <= 223){
            return ($character_first - 192) * 64 + ($character_second - 128);
        }

        #取表情的第三个字节
        $character_third = ord($character[2]);
        if ($character_first >= 224 && $character_first <= 239){
            return ($character_first-224)*4096 + ($character_second - 128)*64 + ($character_third - 128);    
        }

        #取表情的第四个字节
        $character_fourth = ord($character[3]);
        if ($character_first >= 240 && $character_first <= 247) {
            return ($character_first - 240) * 262144 + ($character_second - 128) * 4096 + ($character_third - 128) * 64 + ($character_fourth - 128);
        }
        return false;
    }

    /**
     * [returnCharacterLength 返回字符的字节数]
     * @author zzz
     * @DateTime 2021-04-21T14:16:03+0800
     */
    public function returnCharacterByteNum($character){
        #根据第一个字节大小判断几个字节
        $num = ord($character[0]);
        if ($num >= 0 && $num <= 127){
            return 1;
        }
        if ($num >= 192 && $num <= 223){
            return 2;
        }
        if ($num >= 224 && $num <= 239){
            return 3;
        }
        if ($num >= 240 && $num <= 247) {
            return 4;
        }
    }
}
