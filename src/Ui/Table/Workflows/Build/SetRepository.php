<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Create a new SetRepository instance.
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetRepository
{

    /**
     * Handle the command.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($builder->repository instanceof RepositoryInterface) {
            return;
        }

        /**
         * Default to configured.
         */
        if ($builder->repository) {
            $builder->repository = App::make($builder->repository, compact('builder'));
        }

        /**
         * Fallback for Streams.
         */
        if (!$builder->repository && $builder->stream instanceof StreamInterface) {
            $builder->repository = $builder->stream->repository();
        }
    }
}
