<?php
class Error_Module extends Module {

    function getMain($resolvedRequest) {
      return new Error_Main_View();
    }
}
