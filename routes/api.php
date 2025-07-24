<?php

use Illuminate\Support\Facades\Route;
use Rebing\GraphQL\GraphQLController;

Route::group(["prefix"  => "graphql"], function () {
    Route::get("/", [GraphQLController::class, "query"])->name("graphql");
    Route::post("/", [GraphQLController::class, "query"])->name("graphql");
    Route::patch("/", [GraphQLController::class, "query"])->name("graphql");
    Route::delete("/", [GraphQLController::class, "query"])->name("graphql");
});
