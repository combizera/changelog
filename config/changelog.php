<?php

return [
    // Habilitar interface web
    'enable_web_interface' => true,

    // Configurações da página
    'page' => [
        'title' => 'Changelog',
        'description' => 'Acompanhe as últimas melhorias e atualizações.',
        'route_name' => 'changelog.index',
        'route_prefix' => 'changelog',
        'middleware' => ['web'],
    ],

    // Configurações de exibição
    'display' => [
        'items_per_page' => 10,
        'show_rss' => true,
        'date_format' => 'd/m/Y',
    ],

    // Tipos de changelog disponíveis
    'types' => [
        'new' => 'Novo',
        'improvement' => 'Melhoria',
        'fix' => 'Correção',
        'security' => 'Segurança',
        'deprecated' => 'Descontinuado',
    ],
];
