<?php
namespace app\tool\controller;
use think\Controller;
use app\tool\model\Academy;
use app\tool\model\Major;

class Index extends Controller{
	
    public function updateMajor() {
    	$str = getMajorText();

    	if ( empty($str) )
    		return $this->error('获取数据失败');

    	$arr = explode('<tr>',$str);

    	foreach ($arr as $key => $value) {
    		if (empty($value))
    			continue;
    		$tempArr = explode('<td>', $value);
    		if (empty($tempArr[1]) || empty($tempArr[6]) || $tempArr[1] == '序号')
    			continue;
    		$academy = Academy::get(['academy_name' => $tempArr[6]]);
    		if (empty($academy)) {
    			$academy = new Academy();
    			$academy->academy_name = $tempArr[6];
    			$academy->save();
    		}
    		$major = Major::get(['major_name' => $tempArr[3]]);
    		if (empty($major)) {
    			$major = new Major();
    			$major->major_name = $tempArr[3];
    			$major->academy_id = $academy->id;
    			$major->save();
    		}
    	}

    	return $this->success('更新完成');
    }

}
