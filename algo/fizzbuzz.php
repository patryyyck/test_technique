<?php

for($i = 1; $i <= 50; $i++) {
    echo  ($i % 3 === 0 ? 'Fizz' : '') .
          ($i % 5 === 0 ? 'Buzz' : '')
          ?: $i, PHP_EOL;
}
