<!DOCTYPE html>
<html lang="en">

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta http-equiv="cache-control" content="no-cache">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta http-equiv="x-UA-compatible" content="IE=9">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description"
      content="K'nGELL est un cabinet de conseil et d'ingénierie Logistique spécialisé dans la maitrise des process logistique et production grâce à l'usage de stratégies et tactiques Lean Management et six Sigma (6Sigma">
   <meta name="robots" content="index,follow">
   <meta name="csrftoken" content="<?=$this->token->create(8, $this->getPageTitle())?>" />
   <meta name="frm_name" content="<?=$this->getPageTitle()?>" />
   <link rel="stylesheet" type="image/ico" href="<?='favicon.ico'?>">
   <title>
      <?= $this->getSiteTitle()?>
   </title>
   <!-- Main style -->
   <link href="<?= $this->asset('css/librairies/frontlib', 'css') ?? '' ?>" rel="stylesheet" type="text/css">
   <!-- Plugins css -->
   <link href="<?= $this->asset('css/plugins/homeplugins', 'css') ?? '' ?>" rel="stylesheet" type="text/css">
   <!-- Main style -->
   <link href="<?= $this->asset('css/main/generalMain', 'css') ?? '' ?>" rel="stylesheet" type="text/css">

   <?= $this->content('head'); ?>
</head>

<body id="body">