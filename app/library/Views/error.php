<?php

use App\Views\ErrorView;

/** @var ErrorView $this */

?>

<h3><?= htmlspecialchars($this->exception->getMessage()) ?></h3>
<br/>
<pre><?= htmlspecialchars($this->exception) ?></pre>
