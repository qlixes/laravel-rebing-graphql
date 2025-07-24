<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use App\Traits\ArrayTrait;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class DeleteUserMutation extends Mutation
{
    use ArrayTrait;

    protected $attributes = [
        "name"  => "deleteUser",
    ];

    function type(): Type
    {
        return GraphQL::type("User");
    }

    function args(): array
    {
        return [
            "id"        => [
                "type"  => Type::nonNull(Type::int()),
                "rules" => ["required", "numeric"],
            ],
        ];
    }

    function resolve($root, $args)
    {
        $row = User::withoutTrashed()->find($args["id"]);

        if (!$row) {
            return null;
        }

        $row->delete();

        return $row;
    }
}
