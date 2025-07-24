<?php

namespace App\GraphQL\Queries;

use App\Models\Post;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class PostsQuery extends Query
{
    protected $attributes = [
        "name"  => "posts",
    ];

    function type(): Type
    {
        return Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type("Post"))));
    }

    function args(): array
    {
        return [
            "id"    => [
                "name"  => "id",
                "type"  => Type::int(),
            ],
            "user_id"  => [
                "name"  => "user_id",
                "type"  => Type::int(),
            ],
            "slug" => [
                "name"  => "slug",
                "type"  => Type::string(),
            ],
            "title" => [
                "name"  => "title",
                "type"  => Type::string(),
            ],
        ];
    }

    function resolve($root, $args)
    {
        $post = Post::withoutTrashed();

        if (isset($args["id"])) {
            $post = $post->orWhere("id", $args["id"]);
        }

        if (isset($args["user_id"])) {
            $post = $post->orWhere("user_id", $args["user_id"]);
        }

        if (isset($args["slug"])) {
            $post = $post->orWhere("slug", $args["slug"])->orWhere("slug", "LIKE", $args["slug"]);
        }

        if (isset($args["title"])) {
            $post = $post->orWhere("title", $args["title"])->orWhere("title", "LIKE", $args["title"]);
        }

        return $post->get();
    }
}
