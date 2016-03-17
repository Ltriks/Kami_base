<?php

return [
    'token' => [
        'invalid' => 'Token 无效',
        'expired' => 'Token 过期'
    ],

    'error' => [
        'unknown' => '未知错误',
        '404'     => '您请求的资源不存在',
        'unauthorized' => '没有权限',
    ],
    'unknown_error'    => '未知错误',
    'not_found'        => '没有找到',
    'param_error'        => '没有找到',
    'invalid_session'  => 'Session无效',
    'unauthorized'     => '没有权限',
    'app_sign_error'   => 'Sign无效',
    'account' => [
        'created'  => '账号创建成功',
        'failed'   => '用户名或密码错误',
        '404'      => '您输入的账号不存在',
        'old_password' => '旧密码错误',
        'reset_password' => [
            'subject' => '找回密码邮件',
            'invalid_token'   => 'Token无效' 
        ]
    ],
    'role' => [
        'roles_user'  => '角色下存在用户',
    ],
    'card' => [
        'type_error'  => '卡片类型和所需ID无法对应',
    ]
];
