<?php
return [
    // 初期値
    // 'formGroup' => '{{label}}{{input}}',
    'formGroup' => '<div class="input-field col {{type}}{{required}}">{{input}}{{label}}</div>',
    'radioWrapper' => '<p>{{label}}</p>',
    'checkboxWrapper' => '<div class="wrapper-checkbox">{{label}}</div>',
    'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',

];
