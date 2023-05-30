<?php

namespace Inc;

/**
 * Bootstrap link css and js renderer
 * 
 * @since 1.0.0
 * @author Cak Adi <cakadi190@gmail.com>
 * @version 1.0.0
 */
Class Template
{
  /**
   * Creating link css bootstrap
   * 
   * @return string
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   */
  public static function getCSS()
  {
    return '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />';
  }
  
  /**
   * Creating link script bootstrap
   * 
   * @param bool $defer Defer it to javascript
   * @return string $render
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   */
  public static function getJS($defer = false)
  {
    $render = "<script src=\"https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js\" integrity=\"sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE\" ". ($defer ? 'defer' : '') ." crossorigin=\"anonymous\"></script>
    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js\" integrity=\"sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ\" ". ($defer ? 'defer' : '') ." crossorigin=\"anonymous\"></script>";

    return $render;
  }
}