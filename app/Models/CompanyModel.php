<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request as Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth as Auth;

/**
 * Description of CompanyModel
 *
 * @author gabriel
 */
class CompanyModel extends Model {

    protected $table = 'company';
    protected $primaryKey = 'id';
    public $timestamps = false;

//    public static $model;
//    public function category() {
//        return $this->hasOne('App\Models\CategoryModel', 'id', 'category');
//    }

    /**
     * Метод, който всички компании от базата 
     * @param Request $req
     * @return type
     */
    public function getAllCompany(Request $req) {
        $query = $this->join('category ', 'company.category', '=', 'category.id')
                ->select(
                'company.id'
                , 'company.name'
                , 'company.address'
                , 'category.name as category'
                , 'category.id as categoryId'
                , 'company.bulstat'
                , 'company.note'
                , 'company.date_create'
                , 'company.user_id'
        );

        if (array_key_exists("search", $req->all())) {
            foreach ($req->get('search') as $column => $searchValue) {
                $query->where('company.' . $column, 'like', '%' . $searchValue . '%');
            }
        }
        if (Auth::user()->role->toArray()[0]['name'] != Role::all()->toArray()[0]['name']) {
            $query->where('company.user_id', Auth::user()->id);
        }

        $query->orderBy('company.' . $req->input('ORDER', 'id'), 'ASC');

        return $query->paginate($req->input('list', 5));
    }

    /**
     * метод, който връща една компания по подадено ид
     * @param type $id
     * @return type
     */
    public function getCompany($id) {
        return CompanyModel::join('category ', 'company.category', '=', 'category.id')
                        ->select(
                                'company.id'
                                , 'company.name'
                                , 'company.address'
                                , 'category.name as category'
                                , 'category.id as categoryid'
                                , 'company.bulstat'
                                , 'company.note'
                                , 'company.date_create'
                                , 'company.user_id')
                        ->find($id);
    }

    /**
     * метод, който редактира компания 
     * @param array $attributes
     * @param array $options
     * @return type
     */
    public function update(array $attributes = [], array $options = []) {

        $company = CompanyModel::find($attributes['id']);

        $company->name = $attributes['name'];
        $company->address = $attributes['address'];
        $company->bulstat = $attributes['bulstat'];
        $company->note = $attributes['note'];
        $company->category = $attributes['category'];
        return ($company->save()) ? true : false;
    }

    /**
     * метод за изтриване на компания
     * @param type $id
     * @return boolean
     */
    public function deleteCompany($id) {
        $company = CompanyModel::find($id);

        if ($company->delete()) {
            $persons = PersonModel::where('company', $id)->delete();
            return true;
        }
        return FALSE;
    }

    /**
     * Метод за записване на нова компания
     * @param array $data
     * @return type
     */
    public function saveNewCompany(array $data = []) {
        $company = new CompanyModel;
        $company->name = $data['name'];
        $company->address = $data['address'];
        $company->bulstat = $data['bulstat'];
        $company->note = $data['note'];
        $company->category = $data['category'];
        $company->user_id = Auth::user()->id;
        return($company->save()) ? true : FALSE;
    }

    /**
     * метод, който връща само ид и името на всички компании от базата
     * @return type
     */
    public function getNameIdCompany() {
        $data = CompanyModel::select('company.id', 'company.name')->get();
        return $data;
    }

    /**
     * 
     * @return type
     */
    public function persons() {
        return $this->hasMany('App\Models\PersonModel');
    }

    public function deleteAllCompanyByUserId($user_id) {
        return $this->where('user_id', $user_id)->delete();
    }

    public function getCompanyName($term) {
        return $this->select('id', 'name as label', 'id as value')->where('name', 'like', '%' . $term . '%')->get();
    }

    public function deleteMenyCompany($data) {
        foreach ($data['id'] as $id) {
            if (!$this->deleteCompany($id)) {
                return false;
            }
        }
        return true;
    }

}
