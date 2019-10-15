<?php

namespace Larapp\Options\Observers;

use Larapp\Options\Model\Option;
use Larapp\Options\Facade\Options;
use Larapp\Options\Exceptions\OptionsException;

class OptionObserver
{
    /**
     * Handle the model option "saving" event.
     *
     * @param  \Larapp\Options\Model\Option  $option
     * @return void
     */
    public function saving(Option $option)
    {
        $config = 'options-package.types.'.$option->type;

        $function = config($config);

        if(is_callable($function) === false) {
            throw new OptionsException('The type "'.$option->type.'" is not supported. You must specify this in the options-package.php config file.');
        }
    }

    /**
     * Handle the model option "saved" event.
     *
     * @param  \Larapp\Options\Model\Option  $option
     * @return void
     */
    public function saved(Option $option)
    {
        Options::restore();
    }

    /**
     * Handle the model option "deleted" event.
     *
     * @param  \Larapp\Options\Model\Option  $option
     * @return void
     */
    public function deleted(Option $option)
    {
        Options::restore();
    }   
}
