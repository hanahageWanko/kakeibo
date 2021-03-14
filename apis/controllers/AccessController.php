<?php
class AccessController extends Controller {
  public function generateTokenAction() {
    return $this->render([
      'getData' => $this->getContents(),
      'publishToken' => $this
    ]);
  }
}