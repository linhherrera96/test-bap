<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'status_complete',
        'due_date'
    ];

    public $incrementing = false;

    public function getAllJobs($per_page, $condition)
    {
        $query = $this->select('*');

        //ID
        if (isset($condition->id)) {
            $query->where('id', 'like', '%' . $condition->id . '%');
        }

        //title
        if (isset($condition->title)) {
            $query->where('title', 'like', '%' . $condition->title . '%');
        }

        //description
        if (isset($condition->description)) {
            $query->where('description', 'like', '%' . $condition->description . '%');
        }

        //status complete
        if (isset($condition->status_complete)) {
            $query->where('status_complete', $condition->status_complete);
        }

        //status complete
        if (isset($condition->due_date)) {
            $query->where('due_date', $condition->due_date);
        }

        if (!$per_page) {
            $results = $query->paginate(10);
        } else {
            $results = $query->paginate($per_page);
        }

        return $results;
    }

    public function findByJobId($id)
    {
        return $this->where('id', $id)->first();
    }

    public function updateJob($id, $job)
    {
        return $this->where('id', $id)->update($job);
    }

    public function deleteJobById($id)
    {
        return $this->where('id', $id)->delete();
    }

}
