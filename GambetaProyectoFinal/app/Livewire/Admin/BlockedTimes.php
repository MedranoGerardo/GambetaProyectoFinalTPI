<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Field;
use App\Models\BlockedTime;

class BlockedTimes extends Component
{
    public $field;
    public $date;
    public $start_time;
    public $end_time;
    public $reason;

    public function save()
    {
        $this->validate([
            'field'       => 'required',
            'date'        => 'required|date',
            'start_time'  => 'required',
            'end_time'    => 'required',
            'reason'      => 'nullable|string|max:255',
        ]);

        if ($this->start_time >= $this->end_time) {
            session()->flash('error', 'Start time must be earlier than end time.');
            return;
        }

        // Avoid overlapping
        $exists = BlockedTime::where('field_id', $this->field)
            ->where('date', $this->date)
            ->where(function ($q) {
                $q->whereBetween('start_time', [$this->start_time, $this->end_time])
                  ->orWhereBetween('end_time', [$this->start_time, $this->end_time]);
            })
            ->first();

        if ($exists) {
            session()->flash('error', 'This time range is already blocked.');
            return;
        }

        BlockedTime::create([
            'field_id'   => $this->field,
            'date'       => $this->date,
            'start_time' => $this->start_time,
            'end_time'   => $this->end_time,
            'reason'     => $this->reason,
        ]);

        session()->flash('success', 'Time blocked successfully.');

        $this->start_time = $this->end_time = $this->reason = null;
    }

    public function delete($id)
    {
        BlockedTime::find($id)?->delete();
    }

    public function render()
    {
        return view('livewire.admin.blocked-times', [
            'fields'   => Field::all(),
            'blocked'  => BlockedTime::orderBy('date')->orderBy('start_time')->get(),
        ]);
    }
}