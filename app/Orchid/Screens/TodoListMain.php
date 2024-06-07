<?php

namespace App\Orchid\Screens;

use App\Models\todolists;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class TodoListMain extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return ['todolist' => todolists::paginate(10)];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Дейлики';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Создать задачу')
                ->icon('bs.plus')
                ->route('platform.todolist.create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('todolist', [
                TD::make('title', 'Название задачи')
                    ->sort()
                    ->filter(Input::make())
                    ->render(fn (todolists $todo) => $todo->title),
                TD::make('description', 'Описание задачи')
                    ->sort()
                    ->filter(Input::make())
                    ->render(fn (todolists $todo) => $todo->description),
                TD::make('status', 'Статус')
                    ->render(function (todolists $todolist_bd) {
                        return $todolist_bd->status == 1?'Сделано':'В процессе';
                    }),
                TD::make('actions', 'Действия')
                    ->render(function (todolists $todolist_bd) {
                        return implode(' ', [
                            Link::make('Редактировать')
                                ->icon('bs.pencil')
                                ->route('platform.todolist.edit', $todolist_bd->id),
                            Link::make('Подробнее')
                                ->icon('bs.trash')
                                ->route('platform.todolist.info', $todolist_bd->id),
                        ]);
                    }),
            ])
        ];
    }
}
