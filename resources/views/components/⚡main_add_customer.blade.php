<?php

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

new class extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Search and Filtering State
    public $search = '';
    public $selectedAlphabet = 'ALL';

    // Modal Control State
    public $showModifyModal;
    public $isEditMode;
    public $isNewRecord;

    // Form Fields
    public $customerNo = '';
    public $group = '';
    public $fullName = '';
    public $firstName = '';
    public $middleName = '';
    public $lastName = '';
    public $suffixName = '';
    public $birthDate = '';
    public $tin = '';
    public $contactNo = '';
    public $emailAddress = '';
    public $address = '';
    public $region = '';
    public $province = '';
    public $city = '';
    public $brgy = '';
    public $zipCode = '';
    public $country = 'PHILIPPINES';
    public $remarks = '';

    // Validation Rules
    protected function rules()
    {
        $rules = [
            'group'        => 'required',
            'emailAddress' => 'required|email',
            'address'      => 'required',
            'contactNo'    => 'required',
        ];

        if ($this->group === 'FLEET' || $this->group === 'CORPORATE') {
            $rules['fullName'] = 'required';
        } else {
            $rules['firstName'] = 'required';
            $rules['lastName']  = 'required';
        }

        return $rules;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setAlphabet($letter)
    {
        $this->selectedAlphabet = $letter;
        $this->resetPage();
    }

    #[On('open-new-customer-modal')]
    public function openNewCustomerModal($isEditMode )
    {
        logger($isEditMode);
        $this->resetForm();
        $this->isNewRecord = true;
        $this->isEditMode = true;
        $this->showModifyModal = true;
    }

    public function viewCustomer($customerNo)
    {
        $customer = DB::table('customer_information')->where('Customer_No', $customerNo)->first();

        if (!$customer) {
            return;
        }

        $this->customerNo   = $customer->Customer_No;
        $this->group        = $customer->Group ?? '';
        $this->fullName     = $customer->Full_Name ?? '';
        $this->firstName    = $customer->First_Name ?? '';
        $this->middleName   = $customer->Middle_Name ?? '';
        $this->lastName     = $customer->Last_Name ?? '';
        $this->suffixName   = $customer->Suffix_Name ?? '';
        $this->birthDate    = $customer->Birth_Date ?? '';
        $this->tin          = $customer->TIN ?? '';
        $this->contactNo    = $customer->Contact_No ?? '';
        $this->emailAddress = $customer->Email_Address ?? '';
        $this->address      = $customer->Address ?? '';
        $this->region       = $customer->Region_Code ?? '';
        $this->province     = $customer->Province_Code ?? '';
        $this->city         = $customer->City_Code ?? '';
        $this->brgy         = $customer->Brgy_Code ?? '';
        $this->zipCode      = $customer->Zip_Code ?? '';
        $this->country      = $customer->Country ?? 'PHILIPPINES';
        $this->remarks      = $customer->Remarks ?? '';

        $this->isNewRecord = false;
        $this->isEditMode = false;
        $this->showModifyModal = true;
    }

    public function enableEdit()
    {
        $this->isEditMode = true;
    }

    public function closeModal()
    {
        $this->showModifyModal = false;
        $this->resetForm();
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $computedFullName = in_array($this->group, ['FLEET', 'CORPORATE'])
                ? $this->fullName
                : trim("{$this->firstName} {$this->middleName} {$this->lastName} {$this->suffixName}");

            $data = [
                'Group_ID'      => $this->group,
                'Full_Name'     => $computedFullName,
                'First_Name'    => $this->firstName,
                'Middle_Name'   => $this->middleName,
                'Last_Name'     => $this->lastName,
                'Suffix_Name'   => $this->suffixName,
                'Birth_Date'    => $this->birthDate,
                'TIN'           => $this->tin,
                'Contact_No'    => $this->contactNo,
                'Email_Address' => $this->emailAddress,
                'Address'       => $this->address,
                'Region_Code'   => $this->region,
                'Province_Code' => $this->province,
                'City_Code'     => $this->city,
                'Brgy_Code'     => $this->brgy,
                'Zip_Code'      => $this->zipCode,
                'Country'       => $this->country,
                'Remarks'       => $this->remarks,
            ];

            if ($this->isNewRecord) {
                $data['Customer_No'] = 'CUST-' . time();
                DB::table('customer_information')->insert($data);
            } else {
                DB::table('customer_information')
                    ->where('Customer_No', $this->customerNo)
                    ->update($data);
            }

            DB::commit();
            $this->closeModal();
            $this->dispatch('notify', message: 'Customer saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->reset([
            'customerNo', 'group', 'fullName', 'firstName', 'middleName',
            'lastName', 'suffixName', 'birthDate', 'tin', 'contactNo',
            'emailAddress', 'address', 'region', 'province', 'city',
            'brgy', 'zipCode', 'remarks'
        ]);
        $this->country = 'PHILIPPINES';
        $this->resetValidation();        
    }

        // $query = DB::table('customer_information');        
        // // Alphabet Filtering
        // if ($this->selectedAlphabet !== 'ALL') {
        //     if ($this->selectedAlphabet === '[0-9]') {
        //         $query->whereRaw("LEFT(Full_Name, 1) REGEXP '^[0-9]'");
        //     } elseif ($this->selectedAlphabet === '[SPECIAL CHAR]') {
        //         $query->whereRaw("LEFT(Full_Name, 1) REGEXP '^[^a-zA-Z0-9]'");
        //     } else {
        //         $query->where('Full_Name', 'LIKE', $this->selectedAlphabet . '%');
        //     }
        // }

        // // Global Search
        // if (!empty($this->search)) {
        //     $query->where(function ($q) {
        //         $q->where('Customer_No', 'LIKE', "%{$this->search}%")
        //           ->orWhere('Full_Name', 'LIKE', "%{$this->search}%")
        //           ->orWhere('Email_Address', 'LIKE', "%{$this->search}%")
        //           ->orWhere('Contact_No', 'LIKE', "%{$this->search}%");
        //     });
        // }

        // $customers = $query->paginate(10);

        
};
?>

