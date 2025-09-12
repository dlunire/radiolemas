<?php

declare(strict_types=1);

namespace DLUnire\Models\Views;

use DLCore\Database\Model;

final class TestConection extends Model {
    protected static ?string $table = "SELECT 5 as number";
}
