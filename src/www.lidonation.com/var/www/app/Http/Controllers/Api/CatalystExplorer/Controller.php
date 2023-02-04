<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *
 *      title="Catalyst Explorer API",
 *      description="Cardano Project Catalyst Explorer openapi served by LIDO Nation",
 *      version="1.0.0",
 * ),
 * @OA\Server(
 *     url="/api/catalyst-explorer",
 * ),
 * @OA\Schema(
 *      schema="proposal",
 *      type="object",
 *      @OA\Property(property="id", type="integer", example="687"),
 *      @OA\Property(property="user_id", type="integer", example="543"),
 *      @OA\Property(property="challenge_id", type="integer", example="90"),
 *      @OA\Property(property="fund_id", type="integer", example="97"),
 *      @OA\Property(property="title", type="string", example="DeFi and Microlending for Africa"),
 *      @OA\Property(property="website", type="string", example="mfa.com"),
 *      @OA\Property(property="link", type="string", example="https://www.lidonation.com/en/proposals/cardano-blockchain-lab-in-kenya-f7"),
 *      @OA\Property(
 *          property="embedded_uris",
 *          type="array",
 *          @OA\Items(type="string"),
 *          example="['https://mlabs.city', 'https://github.com/zygomeb']"
 *      ),
 *      @OA\Property(property="ideascale_link", type="string", example="https://cardano.ideascale.com/a/dtd/369449-48080"),
 *      @OA\Property(property="ideascale_user", type="string", example="lidonation"),
 *      @OA\Property(property="ideascale_id", type="integer", example="383975"),
 *      @OA\Property(property="amount_requested", type="integer", example="25000"),
 *      @OA\Property(property="amount_received", type="integer", example="12000"),
 *      @OA\Property(property="project_status", type="string", example="in_progress"),
 *      @OA\Property(property="funding_status", type="string", example="funded"),
 *      @OA\Property(property="yes_votes_count", type="integer", example="42654779"),
 *      @OA\Property(property="no_votes_count", type="integer", example="20335604"),
 *      @OA\Property(property="average_rating", type="float", example="4.49"),
 *      @OA\Property(property="unique_wallets", type="integer", example="264"),
 *      @OA\Property(property="type", type="string", example="challenge"),
 *      @OA\Property(property="problem", type="string", example="How can we enable the creation of micro-lending and Defi dApp solutions that fit the African setting?"),
 *      @OA\Property(property="solution", type="string", example="Extend existing NGO community student hub to add a Cardano Blockchain Lab with dedicated computers, developer mentorship, & community ed."),
 *      @OA\Property(property="experience", type="string", example="14+ Yrs Software & Cloud Engring, Blockchain development, business consulting, world languages, technical writing, teaching, mentored 3 ft ."),
 *      @OA\Property(
 *          property="tags",
 *          type="array",
 *          @OA\Items(
 *              @OA\Property(
 *                  property="id",
 *                  type="integer",
 *                  example="17"
 *              ),
 *              @OA\Property(
 *                  property="slug",
 *                  type="string",
 *                  example="defi"
 *              ),
 *              @OA\Property(
 *                  property="title",
 *                  type="string",
 *                  example="DeFi"
 *              ),
 *          )
 *      ),
 * ),
 * @OA\Schema(
 *      schema="proposals",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/proposal"
 *      ),
 * ),
 * @OA\Schema(
 *      schema="proposals_links",
 *      type="object",
 *      @OA\Property(property="first", type="string", example="http://lidonatio.com/api/catalyst-explorer/proposals?page=1"),
 *      @OA\Property(property="last", type="string", example="http://lidonatio.com/api/catalyst-explorer/proposals?page=21"),
 *      @OA\Property(property="prev", type="string", example="null"),
 *      @OA\Property(property="next", type="string", example="http://lidonatio.com/api/catalyst-explorer/proposals?page=2"),
 * ),
 * @OA\Schema(
 *      schema="proposals_meta",
 *      type="object",
 *      @OA\Property(property="current_page", type="integer", example=3),
 *      @OA\Property(property="from", type="integer", example=1),
 *      @OA\Property(property="last_page", type="integer", example=1),
 *      @OA\Property(property="links", ref="#/components/schemas/proposals_meta_links_array"),
 *      @OA\Property(property="path", type="string", example="http://localhost:8880/api/catalyst-explorer/proposals"),
 *      @OA\Property(property="per_page", type="integer", example=24),
 *      @OA\Property(property="to", type="integer", example=1),
 *      @OA\Property(property="total", type="integer", example=1),
 *
 * ),
 * @OA\Schema(
 *      schema="proposals_meta_links_array",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/proposals_meta_links_array_object"
 *      ),
 * ),
 * @OA\Schema(
 *      schema="proposals_meta_links_array_object",
 *      type="object",
 *      @OA\Property(property="url", type="string", example="http://localhost:8880/api/catalyst-explorer/proposals?page=1"),
 *      @OA\Property(property="label", type="string", example="1"),
 *      @OA\Property(property="active", type="boolean", example=false),
 *),
 *  @OA\Schema(
 *       schema="fund",
 *       type="object",
 *       @OA\Property(property="id", type="integer", example=95),
 *       @OA\Property(property="title", type="string", example="Fund 2"),
 *       @OA\Property(property="proposals_count", type="integer", example=12),
 *       @OA\Property(property="amount", type="string", example="250K"),
 *       @OA\Property(property="currency", type="string", example="usd"),
 *       @OA\Property(property="launch_date", type="string", example="09/21/20"),
 *       @OA\Property(property="currency_symbol", type="string", example="$"),
 *       @OA\Property(property="link", type="string", example="http://localhost:8880/en/project-catalyst/funds/fund-2"),
 *       @OA\Property(property="thumbnail_url", type="null", example=null),
 *       @OA\Property(property="gravatar", type="null", example=null),
 *   ),
 * @OA\Schema(
 *      schema="funds",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/fund"
 *      ),
 * ),
 * @OA\Schema(
 *      schema="funds_links",
 *      type="object",
 *      @OA\Property(property="first", type="string", example="http://localhost:8880/api/catalyst-explorer/funds?page=1"),
 *      @OA\Property(property="last", type="string", example="http://localhost:8880/api/catalyst-explorer/funds?page=1"),
 *      @OA\Property(property="prev", type="string", example=null),
 *      @OA\Property(property="next", type="string", example="http://localhost:8880/api/catalyst-explorer/funds?page=2"),
 * ),
 *  @OA\Schema(
 *      schema="funds_meta",
 *      type="object",
 *      @OA\Property(property="current_page", type="integer", example=1),
 *      @OA\Property(property="from", type="integer", example=1),
 *      @OA\Property(property="last_page", type="integer", example=1),
 *      @OA\Property(property="links", ref="#/components/schemas/funds_meta_links_array"),
 *      @OA\Property(property="path", type="string", example="http://localhost:8880/api/catalyst-explorer/funds"),
 *      @OA\Property(property="per_page", type="integer", example=24),
 *      @OA\Property(property="to", type="integer", example=9),
 *      @OA\Property(property="total", type="integer", example=9),
 * ),
 * * @OA\Schema(
 *      schema="funds_meta_links_array",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/funds_meta_links_array_object"
 *      ),
 * ),
 * @OA\Schema(
 *      schema="funds_meta_links_array_object",
 *      type="object",
 *      @OA\Property(property="url", type="string", example="http://localhost:8880/api/catalyst-explorer/funds?page=1"),
 *      @OA\Property(property="label", type="string", example="1"),
 *      @OA\Property(property="active", type="boolean", example=false),
 *),
 *  @OA\Schema(
 *       schema="tag",
 *       type="object",
 *       @OA\Property(property="id", type="integer", example=95),
 *       @OA\Property(property="title", type="string", example="voluptatem"),
 *       @OA\Property(property="content", type="string", example="Alias rem dolorum dolores impedit hic. Et molestiae quae amet aut possimus. Ex aperiam quisquam suscipit sunt.Vitae eligendi temporibus quia delectus deserunt. Eum eveniet accusantium rerum ut consequatur."),
 *   ),
 * @OA\Schema(
 *      schema="tags",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/tag"
 *      ),
 * ),
 * @OA\Schema(
 *      schema="tags_links",
 *      type="object",
 *      @OA\Property(property="first", type="string", example="http://localhost:8880/api/catalyst-explorer/tags?page=1"),
 *      @OA\Property(property="last", type="string", example="http://localhost:8880/api/catalyst-explorer/tags?page=1"),
 *      @OA\Property(property="prev", type="string", example=null),
 *      @OA\Property(property="next", type="string", example="http://localhost:8880/api/catalyst-explorer/tags?page=2"),
 * ),
 *  @OA\Schema(
 *      schema="tags_meta",
 *      type="object",
 *      @OA\Property(property="current_page", type="integer", example=1),
 *      @OA\Property(property="from", type="integer", example=1),
 *      @OA\Property(property="last_page", type="integer", example=1),
 *      @OA\Property(property="links", ref="#/components/schemas/tags_meta_links_array"),
 *      @OA\Property(property="path", type="string", example="http://localhost:8880/api/catalyst-explorer/tags"),
 *      @OA\Property(property="per_page", type="integer", example=24),
 *      @OA\Property(property="to", type="integer", example=9),
 *      @OA\Property(property="total", type="integer", example=9),
 * ),
 * * @OA\Schema(
 *      schema="tags_meta_links_array",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/tags_meta_links_array_object"
 *      ),
 * ),
 * @OA\Schema(
 *      schema="tags_meta_links_array_object",
 *      type="object",
 *      @OA\Property(property="url", type="string", example="http://localhost:8880/api/catalyst-explorer/tags?page=1"),
 *      @OA\Property(property="label", type="string", example="1"),
 *      @OA\Property(property="active", type="boolean", example=false),
 *),
 *  @OA\Schema(
 *       schema="challenge",
 *       type="object",
 *       @OA\Property(property="id", type="integer", example=92),
 *       @OA\Property(property="fundId", type="integer", example=91),
 *       @OA\Property(property="title", type="string", example="F3: DApp Creation"),
 *       @OA\Property(property="proposalsCount", type="integer", example=76),
 *       @OA\Property(property="amount", type="integer", example="250000"),
 *       @OA\Property(property="currency", type="string", example="usd"),
 *   ),
 * @OA\Schema(
 *      schema="challenges",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/challenge"
 *      ),
 * ),
 * @OA\Schema(
 *      schema="challenges_links",
 *      type="object",
 *      @OA\Property(property="first", type="string", example="http://localhost:8880/api/catalyst-explorer/challenges?page=1"),
 *      @OA\Property(property="last", type="string", example="http://localhost:8880/api/catalyst-explorer/challenges?page=1"),
 *      @OA\Property(property="prev", type="string", example=null),
 *      @OA\Property(property="next", type="string", example="http://localhost:8880/api/catalyst-explorer/challenges?page=2"),
 * ),
 *  @OA\Schema(
 *      schema="challenges_meta",
 *      type="object",
 *      @OA\Property(property="current_page", type="integer", example=1),
 *      @OA\Property(property="from", type="integer", example=1),
 *      @OA\Property(property="last_page", type="integer", example=1),
 *      @OA\Property(property="links", ref="#/components/schemas/challenges_meta_links_array"),
 *      @OA\Property(property="path", type="string", example="http://localhost:8880/api/catalyst-explorer/challenges"),
 *      @OA\Property(property="per_page", type="integer", example=200),
 *      @OA\Property(property="to", type="integer", example=100),
 *      @OA\Property(property="total", type="integer", example=100),
 * ),
 * * @OA\Schema(
 *      schema="challenges_meta_links_array",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/challenges_meta_links_array_object"
 *      ),
 * ),
 * @OA\Schema(
 *      schema="challenges_meta_links_array_object",
 *      type="object",
 *      @OA\Property(property="url", type="string", example="http://localhost:8880/api/catalyst-explorer/challenges?page=1"),
 *      @OA\Property(property="label", type="string", example="1"),
 *      @OA\Property(property="active", type="boolean", example=true),
 *),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
