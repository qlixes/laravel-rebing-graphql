<?php

use Illuminate\Support\Facades\Route;
use Rebing\GraphQL\GraphQLController;

Route::group(["prefix"  => "graphql"], function () {
    Route::get("/", [GraphQLController::class, "query"])->name("graphql.get");
    Route::post("/", [GraphQLController::class, "query"])->name("graphql.post");
    Route::patch("/", [GraphQLController::class, "query"])->name("graphql.patch");
    Route::delete("/", [GraphQLController::class, "query"])->name("graphql.delete");
});
