@switch($action)
  @case('submitted')                @lang('journal.cab.submitted') @break
  @case('resubmitted')              @lang('journal.cab.action_resubmitted') @break
  @case('technic_approved')         @lang('journal.tec.action_approved') @break
  @case('technic_rejected')         @lang('journal.tec.action_rejected') @break
  @case('revision_requested')       @lang('journal.tec.action_revision_requested') @break
  @case('reviewers_assigned')       @lang('journal.mod.action_assigned') @break
  @case('reviewers_reassigned')     @lang('journal.mod.action_reassigned') @break
  @case('review_completed')         @lang('journal.rev.action_review_completed') @break
  @case('all_reviews_completed')    @lang('journal.rev.action_all_reviews_completed') @break
  @case('moderator_final_approved') @lang('journal.mod.action_final_approved') @break
  @case('moderator_final_rejected') @lang('journal.mod.action_final_rejected') @break
  @case('published')                @lang('journal.tec.action_published') @break
  @case('published_edited')         @lang('journal.tec.action_published_edited') @break
  @default {{ $action }}
@endswitch
