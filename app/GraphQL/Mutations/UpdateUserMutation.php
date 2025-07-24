<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use App\Traits\ArrayTrait;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdateUserMutation extends Mutation
{
    use ArrayTrait;

    protected $attributes = [
        "name"  => "updateUser",
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
            "name"      => [
                "type"  => Type::string(),
                "rules" => ["string"],
            ],
            "password"  => [
                "type"  => Type::string(),
                "rules" => ["string"],
            ],
        ];
    }

    function resolve($root, $args)
    {
        $row = User::withoutTrashed()->find($args["id"]);

        if (!$row) {
            return null;
        }

        if (isset($args["name"])) {
            $row->name = $args["name"];
        }

        if (isset($args["password"])) {
            $row->password = Hash::make($args["password"]);
        }

        $row->save();

        return $row;
    }
}
