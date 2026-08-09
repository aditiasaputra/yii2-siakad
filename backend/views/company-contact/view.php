<?php use kartik\detail\DetailView; echo DetailView::widget(['model'=>$model,'attributes'=>[['label'=>'Perusahaan','value'=>$model->company->name],'name','phone','email','address']]); ?>
