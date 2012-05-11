<?php

namespace Orkestra\Common\Daemon;

/**
 * A Daemon that only wants one worker and will always run that worker
 */
class PerpetualDaemon extends Daemon
{
    /**
     * Executes the configured workers
     *
     * @see Orkestra\Common\Daemon\Daemon::execute
     *
     * @throws \RuntimeException if no workers are assigned
     */
    public function execute()
    {
        if (empty($this->_workers)) {
            throw new \RuntimeException('The PerpetualDaemon must be assigned work before it can be executed');
        }

        parent::execute();
    }

    /**
     * Adds a worker
     *
     * The PerpetualDaemon may only be assigned a single worker
     *
     * @param $worker
     * @param array $arguments
     *
     * @see Orkestra\Common\Daemon\Daemon::addWorker
     *
     * @throws \RuntimeException if a worker is already assigned
     */
    public function addWorker($worker, $arguments = array())
    {
        if (!empty($this->_workers)) {
            throw new \RuntimeException('The PerpetualDaemon may only be assigned one worker');
        }

        parent::addWorker($worker, $arguments);
    }

    /**
     * @return bool
     */
    protected function _hasMoreWork()
    {
        return true;
    }

    /**
     * @return array|null
     */
    protected function _getNextWorker()
    {
        return $this->_workers[0];
    }

}