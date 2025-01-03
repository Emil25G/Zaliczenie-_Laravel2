<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2023 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\ExecutionLoop;

use Psy\Shell;

/**
 * Execution Loop Listener interface.
 */
interface Listener
{
    /**
     * Determines whether this listener should be active.
     */
    public static function isSupported(): bool;

    /**
     * Called once before the REPL session starts.
     *
     * @param Shell $shell
     */
    public function beforeRun(Shell $shell);

    /**
     * Called at the start of each loop.
     *
     * @param Shell $shell
     */
    public function beforeLoop(Shell $shell);

    /**
     * Called on users input.
     *
     * Return a new string to override or rewrite users input.
     *
     * @param Shell  $shell
     * @param string $input
     *
     * @return string|null User input override
     */
    public function onInput(Shell $shell, string $input);

    /**
     * Called before executing users code.
     *
     * Return a new string to override or rewrite users code.
     *
     * Note that this is run *after* the Code Cleaner, so if you return invalid
     * or unsafe PHP here, it'll be executed without any of the safety Code
     * Cleaner provides. This comes with the big kid warranty :)
     *
     * @param Shell  $shell
     * @param string $code
     *
     * @return string|null User code override
     */
    public function onExecute(Shell $shell, string $code);

    /**
     * Called at the end of each loop.
     *
     * @param Shell $shell
     */
    public function afterLoop(Shell $shell);

    /**
     * Called once after the REPL session ends.
     *
     * @param Shell $shell
     */
    public function afterRun(Shell $shell);
}
