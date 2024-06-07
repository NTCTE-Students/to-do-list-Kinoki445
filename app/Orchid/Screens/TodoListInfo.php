<?php

namespace App\Orchid\Screens;

use App\Models\todolists;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TodoListInfo extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(todolists $todolist, int $todo_id): array
    {
        return [
            'todolist' => $todolist->find($todo_id),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Инофрмация о задаче';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
        ];     }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('todolist', [
                TD::make('title', 'Название')
                    ->render(fn (todolists $todo) => $todo->title),
                TD::make('description', 'Описание')
                    ->render(fn (todolists $todo) => $todo->description),
                TD::make('status', 'Статус')
                    ->render(function (todolists $todolist_bd) {
                        return $todolist_bd->status == 1 ? 'Сделано' : 'В процессе';
                    }),
            ])
        ];
    }

    public function editTodo(Request $request)
{
    $todolist = todolists::findOrFail($request->input('todolist.id'));
    $todolist->title = $request->input('todolist.title');
    $todolist->description = $request->input('todolist.description');
    $todolist->status = $request->input('todolist.status');
    $todolist->save();

    Toast::info('Задача обновлена успешно!');
    return redirect()->route('platform.todolist');
}
}
