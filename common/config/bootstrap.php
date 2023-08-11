<?php

Yii::setAlias('@root', dirname(__DIR__, 2) . '/');
Yii::setAlias('@admin', Yii::getAlias('@root/admin'));
Yii::setAlias('@api', Yii::getAlias('@root/api'));
Yii::setAlias('@log', Yii::getAlias('@root/log'));

Yii::setAlias('@common', Yii::getAlias('@root/common'));
Yii::setAlias('@data', Yii::getAlias('@common/data'));
Yii::setAlias('@media', Yii::getAlias('@data/media'));

Yii::setAlias('@frontend', Yii::getAlias('@root/frontend'));
Yii::setAlias('@logs', Yii::getAlias('@root/logs'));
Yii::setAlias('@console', Yii::getAlias('@root/console'));
Yii::setAlias('@mail', Yii::getAlias('@root/mail'));
Yii::setAlias('@vendor', Yii::getAlias('@root/vendor'));
Yii::setAlias('@runtime', Yii::getAlias('@root/log'));
