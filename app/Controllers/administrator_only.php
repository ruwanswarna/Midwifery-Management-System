<?php

declare(strict_types=1);

/*
 * Legacy note retained as valid PHP.
 *
 * Administrator checks belong inside the relevant controller action:
 *
 *   (new RoleMiddleware())->handle('Administrator');
 *
 * This file previously contained a standalone method declaration, which made
 * whole-project syntax checks fail. It is intentionally not autoloaded.
 */
