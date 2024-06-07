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

class TodoListEdit extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query($todo_id): array
    {
        $todolist = todolists::findOrFail($todo_id);

        return [
            'todolist' => $todolist
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Изменение задачи';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Изменить задачу')
                ->icon('bs.save')
                ->method('editTodo'),
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
                Input::make('todolist.id')->type('hidden'),
                Input::make('todolist.title')
                    ->title('Название')
                    ->required(),
                TextArea::make('todolist.description')
                    ->title('Описание')
                    ->required()
                    ->rows(5),
                Select::make('todolist.status')
                    ->title('Статус')
                    ->options([
                        '2' => 'В процессе',
                        '1' => 'Сделано',
                    ])
                    ->required(),
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
