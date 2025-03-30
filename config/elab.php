<?php

return [

  //folders
  'folders' => [

    'year' => date('Y')."/",

    'projects' => "projects/",

    'so_procedures' => "so_procedures/",

    'so_protocols' => "so_protocols/",

    'experiments' => "experiments/",

    'themes' => "themes/",

    'images' => "images/",

    'attachments' => "attachments/",

    'files' => "files/",

    'reports' => "reports/",

    'infras' => "infrastructure/"
  ],

  'free_plan' => [

    'projects'    => 1,

    'experiments' => 8,

    'folder_size' => 100000000,

    'users'       => 4,
  ],

  'max_plan' => [

    'projects'    => 25,

    'experiments' => 1000,

    'folder_size' => 100000000*10,

    'users'       => 25,
  ]


];