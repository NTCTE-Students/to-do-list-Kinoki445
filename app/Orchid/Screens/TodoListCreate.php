<?php

namespace App\Orchid\Screens;

use App\Models\todolists;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TodoListCreate extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Создание задачи';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Создать задачу')
                ->icon('bs.save')
                ->method('createTodo'),
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
            Layout::rows([
                Input::make('todo.title')
                    ->title('Название')
                    ->required(),
                TextArea::make('todo.description')
                    ->title('Описание')
                    ->required()
                    ->rows(5),
                Select::make('todo.status')
                    ->title('Статус')
                    ->options([
                        '2' => 'В процессе',
                        '1' => 'Сделано',
                    ])
                    ->required(),
            ])
        ];
    }

    public function createTodo(Request $request)
    {
        $todolist = new todolists();
        $todolist->title = $request->input('todo.title');
        $todolist->description = $request->input('todo.description');
        $todolist->status = $request->input('todo.status');
        $todolist->save();

        Toast::success('Дейлик создан');

        return redirect()->route('platform.todolist');
    }
}
