<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\IssueType;
use App\IssuePriority;

class IssueCreateComposer
{

    private $issueType;
    private $issuePriority;

    public function __construct(IssueType $issueType, IssuePriority $issuePriority)
    {

        $this->issueType = $issueType;
        $this->issuePriority = $issuePriority;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        /** @noinspection StaticInvocationViaThisInspection */
        $issueType = $this->issueType->all();
        /** @noinspection StaticInvocationViaThisInspection */
        $issuePriority = $this->issuePriority->all();
        $view->with(compact('issueType', 'issuePriority'));
    }
}