<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Closure;

class UsersQuery extends Query
{
    protected $attributes = [
        "name"  => "users",
    ];

    function type(): Type
    {
        return Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type("User"))));
    }

    function args(): array
    {
        return [
            "id"    => [
                "name"  => "id",
                "type"  => Type::int(),
            ],
            "name"  => [
                "name"  => "name",
                "type"  => Type::string(),
            ],
            "email" => [
                "name"  => "email",
                "type"  => Type::string(),
            ],
            "sort_by"   => [
                "name"  => "sort_by",
                "type"  => Type::string(),
            ],

        ];
    }

    function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $user = User::withoutTrashed();

        if (isset($args["id"])) {
            $user = $user->where("id", $args["id"]);
        }

        if (isset($args["name"])) {
            $user = $user->where("name", $args["name"])->orWhere("name", "LIKE", "%" . $args["name"] . "%");
        }

        if (isset($args["email"])) {
            $user = $user->where("email", $args["email"])->orWhere("email", "LIKE", "%" . $args["email"] . "%");
        }

        if(isset($args["sort_by"]))
        {
            $user = $user->orderByRaw($args["sort_by"]);
        }

        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $user = $user->select($select)->with($with);

        return $user->get();
    }
}
