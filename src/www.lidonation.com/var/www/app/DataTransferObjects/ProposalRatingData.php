<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ProposalRatingData extends Data
{
    public function __construct(
        public ?int $id,

        public ?string $rationale,

        public ?string $rating,

        public $meta_data,

        public ?ProposalData $proposal,

        public ?CommunityReviewData $community_review,

        #[TypeScriptOptional]
        public ?string $status
    ) {
    }
}
