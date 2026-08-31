<?php

use App\Enums\PersonType;
use App\Models\Person;
use App\Models\User;

it('cria uma pessoa física com sucesso', function () {

    $user = User::factory()->create();

    $person = Person::create([
        'user_id' => $user->id,
        'name' => 'João da Silva',
        'type' => PersonType::Física
    ]);

    expect($person)
        ->user_id->toBe($user->id)
        ->name->toBe('João da Silva')
        ->type->toBe(PersonType::Física);

    $this->assertDatabaseHas('people', [
        'user_id' => $user->id,
        'name' => 'João da Silva',
        'type' => PersonType::Física->value,
    ]);

});

it('pertence a um usuário (belongsTo)', function () {
    $user = User::factory()->create();
    $person = Person::factory()->create(['user_id' => $user->id]);

    expect($person->user)->toBeInstanceOf(User::class)
        ->and($person->user->id)->toBe($user->id);
});

it('um usuário pode ter várias pessoas (hasMany)', function () {
    $user = User::factory()->create();
    Person::factory()->count(3)->create(['user_id' => $user->id]);

    expect($user->people)->toHaveCount(3)
        ->and($user->people->first())->toBeInstanceOf(Person::class);
});

it('deleta as pessoas quando o usuário é deletado (cascade)', function () {
    $user = User::factory()->create();
    Person::factory()->count(2)->create(['user_id' => $user->id]);

    $user->delete();

    expect(Person::count())->toBe(0);
});
