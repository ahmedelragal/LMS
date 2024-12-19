<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\Student;
use Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Str;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;


class StudentsImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    protected $class;
    public $duplicateUsernames = [];

    public function __construct($classId)
    {
        $this->class = Group::findOrFail($classId);
    }

    public function model(array $row)
    {
        if (empty($row['username'])) {
            return null;
        }

        $username = str_replace(' ', '_', $row['username']);

        if (preg_match('/^\d/', $username)) {
            throw new \Exception("The username '{$username}' cannot start with a number.");
        }

        $existingStudent = Student::where('username', $username)->first();

        if ($existingStudent) {
            if ($existingStudent->class_id) {
                $this->duplicateUsernames[] = $username;
                return null;
            } else {
                $existingStudent->update(['class_id' => $this->class->id]);
                return null;
            }
        }

        $gender = !empty($row['gender']) ? strtolower($row['gender']) : null;
        $password = Str::random(8);

        return new Student([
            'username' => $username,
            'password' => Hash::make($password),
            'plain_password' => $password,
            'gender' => $gender,
            'school_id' => $this->class->school_id,
            'stage_id' => $this->class->stage_id,
            'is_active' => 1,
            'image' => null,
            'class_id' => $this->class->id,
        ]);
    }

}
