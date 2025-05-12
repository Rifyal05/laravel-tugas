<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Categories; 
use Livewire\WithPagination;

class CategoryTable extends Component
{
    use WithPagination;

    public string $searchQuery = '';
    protected $paginationTheme = 'tailwind';

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Categories::query()
            ->when($this->searchQuery !== '', function ($query) {
                $query->where('name', 'like', '%' . $this->searchQuery . '%')
                      ->orWhere('description', 'like', '%' . $this->searchQuery . '%');
            })
            ->orderBy('created_at', 'desc') 
            ->paginate(10); 

        return view('livewire.category-table', [
            'categories' => $categories,
        ]);
    }
}