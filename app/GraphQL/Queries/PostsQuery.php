<?php

namespace App\GraphQL\Queries;

use App\Models\Post;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Closure;

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

            "sort_by"   => [
                "name"  => "sort_by",
                "type"  => Type::string(),
            ],
        ];
    }

    function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $post = Post::withoutTrashed();

        if (isset($args["id"])) {
            $post = $post->where("id", $args["id"]);
        }

        if (isset($args["user_id"])) {
            $post = $post->where("user_id", $args["user_id"]);
        }

        if (isset($args["title"])) {
            $post = $post->where("title", $args["title"])->orWhere("title", "LIKE", "%" . $args["title"] . "%");
        }

        if(isset($args["sort_by"]))
        {
            $post = $post->orderByRaw($args["sort_by"]);
        }

        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $post = $post->select($select)->with($with);

        return $post->get();
    }
}
