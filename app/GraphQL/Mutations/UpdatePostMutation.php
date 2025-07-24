<?php

namespace App\GraphQL\Mutations;

use App\Models\Post;
use App\Traits\ArrayTrait;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdatePostMutation extends Mutation
{
    use ArrayTrait;

    protected $attributes = [
        "name"  => "updatePost",
    ];

    function type(): Type
    {
        return GraphQL::type("Post");
    }

    function args(): array
    {
        return [
            "id"        => [
                "type"  => Type::nonNull(Type::int()),
                "rules" => ["required", "numeric"],
            ],
            "title"      => [
                "type"  => Type::string(),
                "rules" => ["string"],
            ],
            "content"  => [
                "type"  => Type::string(),
                "rules" => ["string"],
            ],
        ];
    }

    function resolve($root, $args)
    {
        $row = Post::withoutTrashed()->find($args["id"]);

        if (!$row) {
            return null;
        }

        if (isset($args["title"])) {
            $row->title = $args["title"];
        }

        if (isset($args["content"])) {
            $row->content = $args["content"];
        }

        $row->save();

        return $row;
    }
}
