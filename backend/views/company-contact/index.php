<?php
use kartik\grid\GridView; use yii\helpers\Html;
$this->title='Contact Person';
echo GridView::widget(['dataProvider'=>$dataProvider,'filterModel'=>$searchModel,'pjax'=>false,'toolbar'=>[[ 'content'=>Html::a('Tambah Contact Person',['create'],['class'=>'btn btn-success'])]],'columns'=>[['class'=>'kartik\grid\SerialColumn'],['attribute'=>'company_id','label'=>'Perusahaan','value'=>static fn($m)=>$m->company->name],['attribute'=>'name','label'=>'Nama Pegawai'],['attribute'=>'phone','label'=>'No. Telp'],['class'=>'kartik\grid\ActionColumn']]]);
