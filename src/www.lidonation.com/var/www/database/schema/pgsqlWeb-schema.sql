--
-- PostgreSQL database dump
--

-- Dumped from database version 15.2
-- Dumped by pg_dump version 15.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: public; Type: SCHEMA; Schema: -; Owner: -
--

-- *not* creating schema, since initdb creates it


--
-- Name: xc_au_view_proposals_updated_at(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION public.xc_au_view_proposals_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
                          BEGIN
                            NEW."updated_at" = NOW();
                            RETURN NEW;
                          END;
                          $$;


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: discussions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.discussions (
    id bigint NOT NULL,
    model_id bigint,
    user_id bigint,
    model_type character varying(255),
    title character varying(255),
    status character varying(255) DEFAULT 'draft'::character varying NOT NULL,
    "order" integer DEFAULT 0,
    content text,
    published_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    comment_prompt text
);


--
-- Name: legacy_comments; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.legacy_comments (
    id bigint NOT NULL,
    parent_id bigint,
    user_id bigint,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL,
    title character varying(255),
    content text NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    status character varying(30) DEFAULT 'pending'::character varying,
    published_at timestamp(0) without time zone,
    type character varying(255) DEFAULT 'App\Models\Comment'::character varying NOT NULL
);


--
-- Name: proposals; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.proposals (
    id bigint NOT NULL,
    user_id bigint,
    fund_id bigint,
    title jsonb NOT NULL,
    slug text NOT NULL,
    website text,
    excerpt text,
    amount_requested double precision DEFAULT '0'::double precision NOT NULL,
    definition_of_success text,
    status character varying(255) NOT NULL,
    meta_data json,
    funded_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    yes_votes_count integer,
    no_votes_count integer,
    comment_prompt text,
    social_excerpt text,
    team_id bigint,
    ideascale_link text,
    type text,
    meta_title json,
    problem json,
    solution json,
    experience json,
    content json,
    amount_received double precision,
    funding_status text,
    funding_updated_at date,
    currency character varying(255),
    opensource boolean,
    ranking_total integer DEFAULT 0 NOT NULL,
    quickpitch character varying(255),
    quickpitch_length integer,
    CONSTRAINT proposals_currency_check CHECK (((currency)::text = ANY ((ARRAY['USD'::character varying, 'ADA'::character varying])::text[])))
);


--
-- Name: ratings; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.ratings (
    id bigint NOT NULL,
    model_id bigint NOT NULL,
    model_type text NOT NULL,
    comment_id bigint,
    user_id bigint,
    rating integer NOT NULL,
    status text DEFAULT 'published'::text NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: _proposal_ratings; Type: MATERIALIZED VIEW; Schema: public; Owner: -
--

CREATE MATERIALIZED VIEW public._proposal_ratings AS
 SELECT ratings.id,
    ratings.rating,
    legacy_comments.content AS rationale,
    legacy_comments.id AS assessment_id,
    discussions.id AS discussion_id,
    discussions.content AS discussion,
    proposals.id AS proposal_id,
    proposals.fund_id,
    proposals.status,
    proposals.user_id AS primary_author
   FROM (((public.ratings
     LEFT JOIN public.discussions ON (((ratings.model_id = discussions.id) AND (ratings.model_type = 'App\Models\Discussion'::text))))
     LEFT JOIN public.legacy_comments ON ((ratings.comment_id = legacy_comments.id)))
     RIGHT JOIN public.proposals ON (((discussions.model_id = proposals.id) AND ((discussions.model_type)::text = 'App\Models\Proposal'::text))))
  WITH NO DATA;


--
-- Name: action_events; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.action_events (
    id bigint NOT NULL,
    batch_id character(36) NOT NULL,
    user_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    actionable_type character varying(255) NOT NULL,
    actionable_id bigint NOT NULL,
    target_type character varying(255) NOT NULL,
    target_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint,
    fields text NOT NULL,
    status character varying(25) DEFAULT 'running'::character varying NOT NULL,
    exception text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    original text,
    changes text
);


--
-- Name: action_events_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.action_events_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: action_events_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.action_events_id_seq OWNED BY public.action_events.id;


--
-- Name: anonymous_bookmarks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.anonymous_bookmarks (
    id uuid NOT NULL,
    bookmark text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: answer_responses; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.answer_responses (
    id bigint NOT NULL,
    user_id bigint,
    question_id bigint NOT NULL,
    quiz_id bigint NOT NULL,
    question_answer_id bigint NOT NULL,
    stake_address text,
    status text DEFAULT 'published'::text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    context_id bigint,
    context_type text
);


--
-- Name: answer_responses_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.answer_responses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: answer_responses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.answer_responses_id_seq OWNED BY public.answer_responses.id;


--
-- Name: assessment_reviews; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.assessment_reviews (
    id bigint NOT NULL,
    assessor_id character varying(255) NOT NULL,
    excellent_count integer DEFAULT 0 NOT NULL,
    good_count integer DEFAULT 0 NOT NULL,
    filtered_out_count integer DEFAULT 0 NOT NULL,
    qa_rationale json,
    flagged boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: assessment_reviews_comments_assessors; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.assessment_reviews_comments_assessors (
    id bigint NOT NULL,
    assessment_review_id bigint NOT NULL,
    assessment_id bigint NOT NULL,
    assessor_id bigint NOT NULL
);


--
-- Name: assessment_reviews_comments_assessors_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.assessment_reviews_comments_assessors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: assessment_reviews_comments_assessors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.assessment_reviews_comments_assessors_id_seq OWNED BY public.assessment_reviews_comments_assessors.id;


--
-- Name: assessment_reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.assessment_reviews_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: assessment_reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.assessment_reviews_id_seq OWNED BY public.assessment_reviews.id;


--
-- Name: assessors; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.assessors (
    id bigint NOT NULL,
    assessor_id character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: assessors_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.assessors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: assessors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.assessors_id_seq OWNED BY public.assessors.id;


--
-- Name: bookmark_collections; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.bookmark_collections (
    id bigint NOT NULL,
    user_id bigint,
    title text NOT NULL,
    content text,
    color text NOT NULL,
    visibility text DEFAULT 'unlisted'::text NOT NULL,
    status text DEFAULT 'draft'::text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    type text DEFAULT 'App\Models\BookmarkCollection'::text NOT NULL
);


--
-- Name: bookmark_collections_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.bookmark_collections_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: bookmark_collections_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.bookmark_collections_id_seq OWNED BY public.bookmark_collections.id;


--
-- Name: bookmark_items; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.bookmark_items (
    id bigint NOT NULL,
    bookmark_collection_id bigint NOT NULL,
    parent_id bigint,
    model_id bigint NOT NULL,
    model_type text NOT NULL,
    title text,
    content text,
    link text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    action smallint
);


--
-- Name: COLUMN bookmark_items.action; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.bookmark_items.action IS '0: no, 1: yes, 2: abstain';


--
-- Name: bookmark_items_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.bookmark_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: bookmark_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.bookmark_items_id_seq OWNED BY public.bookmark_items.id;


--
-- Name: catalyst_group_has_catalyst_user; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_group_has_catalyst_user (
    catalyst_user_id bigint NOT NULL,
    catalyst_group_id bigint NOT NULL
);


--
-- Name: catalyst_group_has_proposal; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_group_has_proposal (
    catalyst_group_id bigint NOT NULL,
    proposal_id bigint NOT NULL
);


--
-- Name: catalyst_groups; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_groups (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    bio json,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    slug text,
    status text,
    meta_title text,
    website character varying(255),
    twitter character varying(255),
    discord character varying(255),
    github character varying(255)
);


--
-- Name: catalyst_groups_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.catalyst_groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: catalyst_groups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.catalyst_groups_id_seq OWNED BY public.catalyst_groups.id;


--
-- Name: catalyst_intents; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_intents (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    brief json,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: catalyst_intents_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.catalyst_intents_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: catalyst_intents_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.catalyst_intents_id_seq OWNED BY public.catalyst_intents.id;


--
-- Name: catalyst_ledger_snapshots; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_ledger_snapshots (
    id bigint NOT NULL,
    snapshot_id text NOT NULL,
    size bigint NOT NULL,
    epoch text NOT NULL,
    slot text NOT NULL,
    fund_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: catalyst_ledger_snapshots_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.catalyst_ledger_snapshots_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: catalyst_ledger_snapshots_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.catalyst_ledger_snapshots_id_seq OWNED BY public.catalyst_ledger_snapshots.id;


--
-- Name: catalyst_ranks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_ranks (
    id bigint NOT NULL,
    user_id bigint,
    model_id bigint NOT NULL,
    model_type text NOT NULL,
    rank integer NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: catalyst_ranks_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.catalyst_ranks_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: catalyst_ranks_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.catalyst_ranks_id_seq OWNED BY public.catalyst_ranks.id;


--
-- Name: catalyst_registrations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_registrations (
    id bigint NOT NULL,
    tx text NOT NULL,
    stake_pub text NOT NULL,
    stake_key text NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone
);


--
-- Name: catalyst_registrations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.catalyst_registrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: catalyst_registrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.catalyst_registrations_id_seq OWNED BY public.catalyst_registrations.id;


--
-- Name: catalyst_reports; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_reports (
    id bigint NOT NULL,
    proposal_id bigint NOT NULL,
    project_status text,
    on_track text,
    off_track_reason text,
    completion_target text,
    content text,
    attachment text,
    token_launching text,
    token_utility text,
    community_size text,
    circle_feedback text,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: catalyst_reports_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.catalyst_reports_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: catalyst_reports_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.catalyst_reports_id_seq OWNED BY public.catalyst_reports.id;


--
-- Name: catalyst_snapshots; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_snapshots (
    id bigint NOT NULL,
    model_id bigint NOT NULL,
    model_type text NOT NULL,
    epoch integer NOT NULL,
    "order" integer NOT NULL,
    snapshot_at timestamp(0) without time zone NOT NULL
);


--
-- Name: catalyst_snapshots_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.catalyst_snapshots_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: catalyst_snapshots_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.catalyst_snapshots_id_seq OWNED BY public.catalyst_snapshots.id;


--
-- Name: catalyst_tallies; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_tallies (
    id bigint NOT NULL,
    model_id bigint,
    model_type text,
    hash text NOT NULL,
    tally integer DEFAULT 0 NOT NULL,
    updated_at timestamp(0) without time zone,
    context_id bigint,
    context_type text
);


--
-- Name: catalyst_tallies_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.catalyst_tallies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: catalyst_tallies_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.catalyst_tallies_id_seq OWNED BY public.catalyst_tallies.id;


--
-- Name: catalyst_user_has_proposal; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_user_has_proposal (
    proposal_id bigint NOT NULL,
    catalyst_user_id bigint NOT NULL
);


--
-- Name: catalyst_users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_users (
    id bigint NOT NULL,
    ideascale_id integer,
    username text,
    email text,
    name text,
    bio text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    twitter text,
    linkedin text,
    discord text,
    ideascale text,
    claimed_by bigint,
    telegram text,
    title character varying(255),
    role character varying(255) DEFAULT 'member'::character varying NOT NULL,
    CONSTRAINT catalyst_users_role_check CHECK (((role)::text = ANY ((ARRAY['admin'::character varying, 'member'::character varying])::text[])))
);


--
-- Name: catalyst_users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.catalyst_users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: catalyst_users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.catalyst_users_id_seq OWNED BY public.catalyst_users.id;


--
-- Name: catalyst_voters; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_voters (
    id bigint NOT NULL,
    stake_pub text NOT NULL,
    stake_key text NOT NULL,
    voting_pub text NOT NULL,
    voting_key text NOT NULL,
    cat_id text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: catalyst_voters_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.catalyst_voters_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: catalyst_voters_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.catalyst_voters_id_seq OWNED BY public.catalyst_voters.id;


--
-- Name: catalyst_votes; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_votes (
    id bigint NOT NULL,
    user_id bigint,
    model_id bigint NOT NULL,
    model_type text NOT NULL,
    content text,
    vote text NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: catalyst_votes_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.catalyst_votes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: catalyst_votes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.catalyst_votes_id_seq OWNED BY public.catalyst_votes.id;


--
-- Name: catalyst_voting_powers; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.catalyst_voting_powers (
    id bigint NOT NULL,
    voting_power double precision NOT NULL,
    catalyst_snapshot_id bigint,
    voter_id text NOT NULL,
    consumed boolean,
    votes_cast integer DEFAULT 0 NOT NULL
);


--
-- Name: catalyst_voting_powers_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.catalyst_voting_powers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: catalyst_voting_powers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.catalyst_voting_powers_id_seq OWNED BY public.catalyst_voting_powers.id;


--
-- Name: categories; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    parent_id bigint,
    title character varying(75) NOT NULL,
    meta_title character varying(150) NOT NULL,
    slug character varying(150) NOT NULL,
    content text,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    color text
);


--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- Name: causes; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.causes (
    id bigint NOT NULL,
    user_id bigint,
    title character varying(255) NOT NULL,
    meta_title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    content text,
    status text DEFAULT 'submitted'::text NOT NULL,
    published_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    voting_id character varying(255)
);


--
-- Name: causes_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.causes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: causes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.causes_id_seq OWNED BY public.causes.id;


--
-- Name: ccv4_ballot_choices; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.ccv4_ballot_choices (
    id bigint NOT NULL,
    ballot_id text NOT NULL,
    voter_id text NOT NULL,
    voter_power bigint NOT NULL,
    ballot_choice smallint NOT NULL,
    ballot_choice_rank smallint NOT NULL,
    tx_hash text NOT NULL,
    block_height integer NOT NULL,
    block_time integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: ccv4_ballot_choices_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.ccv4_ballot_choices_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ccv4_ballot_choices_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.ccv4_ballot_choices_id_seq OWNED BY public.ccv4_ballot_choices.id;


--
-- Name: comment_notification_subscriptions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.comment_notification_subscriptions (
    id bigint NOT NULL,
    commentable_type character varying(255) NOT NULL,
    commentable_id bigint NOT NULL,
    subscriber_type character varying(255) NOT NULL,
    subscriber_id bigint NOT NULL,
    type character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: comment_notification_subscriptions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.comment_notification_subscriptions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: comment_notification_subscriptions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.comment_notification_subscriptions_id_seq OWNED BY public.comment_notification_subscriptions.id;


--
-- Name: comments; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.comments (
    id bigint NOT NULL,
    commentator_type character varying(255),
    commentator_id bigint,
    commentable_type character varying(255) NOT NULL,
    commentable_id bigint NOT NULL,
    parent_id bigint,
    original_text text NOT NULL,
    text text NOT NULL,
    extra json,
    approved_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: comments_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.comments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: comments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.comments_id_seq OWNED BY public.legacy_comments.id;


--
-- Name: comments_id_seq1; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.comments_id_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: comments_id_seq1; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.comments_id_seq1 OWNED BY public.comments.id;


--
-- Name: commits; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.commits (
    id bigint NOT NULL,
    repo_id bigint NOT NULL,
    content character varying(255) NOT NULL,
    hash character varying(255) NOT NULL,
    author character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: commits_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.commits_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: commits_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.commits_id_seq OWNED BY public.commits.id;


--
-- Name: courses; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.courses (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    content character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: courses_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.courses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: courses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.courses_id_seq OWNED BY public.courses.id;


--
-- Name: definitions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.definitions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    content text NOT NULL,
    weight integer DEFAULT 0 NOT NULL,
    status character varying(30) DEFAULT 'draft'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: definitions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.definitions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: definitions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.definitions_id_seq OWNED BY public.definitions.id;


--
-- Name: delegations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.delegations (
    id bigint NOT NULL,
    catalyst_registration_id bigint NOT NULL,
    voting_pub character varying(255) NOT NULL,
    weight integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    cat_onchain_id text
);


--
-- Name: delegations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.delegations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: delegations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.delegations_id_seq OWNED BY public.delegations.id;


--
-- Name: discussions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.discussions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: discussions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.discussions_id_seq OWNED BY public.discussions.id;


--
-- Name: events; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.events (
    id bigint NOT NULL,
    name json NOT NULL,
    content json,
    starts_at timestamp(0) without time zone NOT NULL,
    ends_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    kind character varying(255),
    frequency character varying(255)
);


--
-- Name: events_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.events_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: events_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.events_id_seq OWNED BY public.events.id;


--
-- Name: every_epochs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.every_epochs (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    epoch integer NOT NULL,
    title json NOT NULL,
    content json NOT NULL,
    status text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: every_epochs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.every_epochs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: every_epochs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.every_epochs_id_seq OWNED BY public.every_epochs.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: flags; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.flags (
    id bigint NOT NULL,
    model_id bigint NOT NULL,
    model_type text NOT NULL,
    type text NOT NULL,
    score text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: flags_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.flags_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: flags_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.flags_id_seq OWNED BY public.flags.id;


--
-- Name: funds; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.funds (
    id bigint NOT NULL,
    user_id bigint,
    title character varying(150) NOT NULL,
    meta_title character varying(150) NOT NULL,
    slug character varying(150) NOT NULL,
    excerpt text,
    comment_prompt text,
    content text,
    amount double precision DEFAULT '0'::double precision NOT NULL,
    status character varying(255),
    launched_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    parent_id bigint,
    awarded_at timestamp(0) without time zone,
    color text,
    label text,
    currency text DEFAULT 'usd'::text NOT NULL,
    type character varying(255) DEFAULT 'catalyst_proposal'::character varying NOT NULL,
    assessment_started_at timestamp(0) without time zone
);


--
-- Name: funds_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.funds_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: funds_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.funds_id_seq OWNED BY public.funds.id;


--
-- Name: giveaway_model; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.giveaway_model (
    id bigint NOT NULL,
    model_id bigint NOT NULL,
    model_type text NOT NULL,
    giveaway_id bigint NOT NULL
);


--
-- Name: giveaway_model_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.giveaway_model_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: giveaway_model_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.giveaway_model_id_seq OWNED BY public.giveaway_model.id;


--
-- Name: giveaways; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.giveaways (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    title json NOT NULL,
    meta_title json,
    social_excerpt json,
    content json,
    type text,
    status text DEFAULT 'draft'::text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    tx_metadata json
);


--
-- Name: giveaways_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.giveaways_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: giveaways_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.giveaways_id_seq OWNED BY public.giveaways.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: language_lines; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.language_lines (
    id bigint NOT NULL,
    "group" character varying(255) NOT NULL,
    key character varying(255) NOT NULL,
    text text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: language_lines_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.language_lines_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: language_lines_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.language_lines_id_seq OWNED BY public.language_lines.id;


--
-- Name: learning_attempts; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.learning_attempts (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    learning_module_id bigint NOT NULL,
    learning_topic_id bigint NOT NULL,
    learning_lesson_id bigint NOT NULL,
    quiz_id bigint NOT NULL,
    question_id bigint NOT NULL,
    question_answer_id bigint NOT NULL,
    answer_response_id bigint NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT learning_attempts_status_check CHECK (((status)::text = ANY ((ARRAY['started'::character varying, 'completed'::character varying])::text[])))
);


--
-- Name: learning_attempts_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.learning_attempts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: learning_attempts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.learning_attempts_id_seq OWNED BY public.learning_attempts.id;


--
-- Name: learning_lesson_learning_topic; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.learning_lesson_learning_topic (
    learning_lesson_id bigint NOT NULL,
    learning_topic_id bigint NOT NULL
);


--
-- Name: learning_lessons; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.learning_lessons (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    model_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    title json NOT NULL,
    content json,
    "order" integer NOT NULL,
    length integer,
    difficulty character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: learning_lessons_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.learning_lessons_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: learning_lessons_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.learning_lessons_id_seq OWNED BY public.learning_lessons.id;


--
-- Name: learning_module_learning_topic; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.learning_module_learning_topic (
    learning_module_id bigint NOT NULL,
    learning_topic_id bigint NOT NULL
);


--
-- Name: learning_modules; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.learning_modules (
    id bigint NOT NULL,
    slug character varying(255) NOT NULL,
    user_id bigint NOT NULL,
    title json NOT NULL,
    content json NOT NULL,
    difficulty character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: learning_modules_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.learning_modules_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: learning_modules_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.learning_modules_id_seq OWNED BY public.learning_modules.id;


--
-- Name: learning_topics; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.learning_topics (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    title json NOT NULL,
    content json NOT NULL,
    difficulty character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    "order" integer DEFAULT 0 NOT NULL
);


--
-- Name: learning_topics_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.learning_topics_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: learning_topics_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.learning_topics_id_seq OWNED BY public.learning_topics.id;


--
-- Name: lesson_post; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.lesson_post (
    id bigint NOT NULL,
    lesson_id bigint NOT NULL,
    post_id bigint NOT NULL
);


--
-- Name: lesson_post_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.lesson_post_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lesson_post_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.lesson_post_id_seq OWNED BY public.lesson_post.id;


--
-- Name: lessons; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.lessons (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    course_id bigint NOT NULL,
    title character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    completed_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: lessons_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.lessons_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lessons_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.lessons_id_seq OWNED BY public.lessons.id;


--
-- Name: lido_reactions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.lido_reactions (
    id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL,
    commenter_type character varying(255) NOT NULL,
    commenter_id bigint,
    reaction character varying(255) NOT NULL,
    type character varying(255) NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: lido_reactions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.lido_reactions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lido_reactions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.lido_reactions_id_seq OWNED BY public.lido_reactions.id;


--
-- Name: links; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.links (
    id bigint NOT NULL,
    type character varying(255),
    link text NOT NULL,
    label character varying(255),
    title text,
    status character varying(255) DEFAULT 'published'::character varying,
    "order" integer DEFAULT 0,
    valid boolean DEFAULT true,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: links_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.links_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: links_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.links_id_seq OWNED BY public.links.id;


--
-- Name: media; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.media (
    id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL,
    uuid uuid,
    collection_name character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    file_name character varying(255) NOT NULL,
    mime_type character varying(255),
    disk character varying(255) NOT NULL,
    conversions_disk character varying(255),
    size bigint NOT NULL,
    manipulations json NOT NULL,
    custom_properties json NOT NULL,
    generated_conversions json NOT NULL,
    responsive_images json NOT NULL,
    order_column integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: media_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.media_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: media_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.media_id_seq OWNED BY public.media.id;


--
-- Name: metas; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.metas (
    id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL,
    key character varying(75) NOT NULL,
    content text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: metas_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.metas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: metas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.metas_id_seq OWNED BY public.metas.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: mint_txes; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.mint_txes (
    id bigint NOT NULL,
    mint_id bigint NOT NULL,
    user_id bigint NOT NULL,
    score double precision NOT NULL,
    distribution_percent double precision NOT NULL,
    amount integer NOT NULL,
    type character varying(255),
    status character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    policy_id text
);


--
-- Name: mint_txes_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.mint_txes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mint_txes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.mint_txes_id_seq OWNED BY public.mint_txes.id;


--
-- Name: mints; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.mints (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    type character varying(255) NOT NULL,
    "group" character varying(255) NOT NULL,
    epoch integer,
    memo character varying(255) NOT NULL,
    status character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    mint_seed_tx character varying(255),
    mint_seed_tx_index character varying(255),
    mint_seed_amount integer,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: mints_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.mints_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: mints_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.mints_id_seq OWNED BY public.mints.id;


--
-- Name: model_categories; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.model_categories (
    id bigint NOT NULL,
    category_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


--
-- Name: model_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.model_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: model_categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.model_categories_id_seq OWNED BY public.model_categories.id;


--
-- Name: model_has_permissions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.model_has_permissions (
    permission_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


--
-- Name: model_has_roles; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.model_has_roles (
    role_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


--
-- Name: model_links; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.model_links (
    id bigint NOT NULL,
    link_id bigint NOT NULL,
    model_id bigint NOT NULL,
    model_type character varying(255) NOT NULL
);


--
-- Name: model_links_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.model_links_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: model_links_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.model_links_id_seq OWNED BY public.model_links.id;


--
-- Name: model_quiz; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.model_quiz (
    id bigint NOT NULL,
    quiz_id bigint NOT NULL,
    model_id bigint NOT NULL,
    model_type text NOT NULL
);


--
-- Name: model_quiz_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.model_quiz_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: model_quiz_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.model_quiz_id_seq OWNED BY public.model_quiz.id;


--
-- Name: model_snippets; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.model_snippets (
    id bigint NOT NULL,
    model_id bigint NOT NULL,
    snippet_id bigint NOT NULL,
    model_type text NOT NULL
);


--
-- Name: model_snippets_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.model_snippets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: model_snippets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.model_snippets_id_seq OWNED BY public.model_snippets.id;


--
-- Name: model_tags; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.model_tags (
    id bigint NOT NULL,
    tag_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


--
-- Name: model_tags_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.model_tags_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: model_tags_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.model_tags_id_seq OWNED BY public.model_tags.id;


--
-- Name: model_wallets; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.model_wallets (
    id bigint NOT NULL,
    wallet_id bigint NOT NULL,
    model_id bigint NOT NULL,
    model_type character varying(255) NOT NULL
);


--
-- Name: model_wallets_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.model_wallets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: model_wallets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.model_wallets_id_seq OWNED BY public.model_wallets.id;


--
-- Name: nfts; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.nfts (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    artist_id bigint,
    model_id bigint,
    model_type text,
    storage_link text,
    preview_link text,
    name text,
    policy text,
    owner_address text,
    description json,
    rarity text,
    status text DEFAULT 'draft'::text NOT NULL,
    price double precision,
    currency text DEFAULT 'usd'::text NOT NULL,
    metadata json,
    minted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    qty integer DEFAULT 1 NOT NULL
);


--
-- Name: nfts_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.nfts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: nfts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.nfts_id_seq OWNED BY public.nfts.id;


--
-- Name: notification_request_templates; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.notification_request_templates (
    id bigint NOT NULL,
    who_id bigint NOT NULL,
    who_type character varying(255) NOT NULL,
    what_type character varying(255) NOT NULL,
    what_filter json NOT NULL,
    "when" character varying(255) NOT NULL,
    "where" character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    what_id bigint
);


--
-- Name: notification_request_templates_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.notification_request_templates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: notification_request_templates_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.notification_request_templates_id_seq OWNED BY public.notification_request_templates.id;


--
-- Name: notification_requests; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.notification_requests (
    id bigint NOT NULL,
    notification_request_template_id bigint NOT NULL,
    who_id bigint NOT NULL,
    who_type character varying(255) NOT NULL,
    what_id bigint NOT NULL,
    what_type character varying(255) NOT NULL,
    "when" character varying(255) NOT NULL,
    "where" character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: notification_requests_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.notification_requests_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: notification_requests_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.notification_requests_id_seq OWNED BY public.notification_requests.id;


--
-- Name: nova_field_attachments; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.nova_field_attachments (
    id integer NOT NULL,
    attachable_type character varying(255) NOT NULL,
    attachable_id bigint NOT NULL,
    attachment character varying(255) NOT NULL,
    disk character varying(255) NOT NULL,
    url character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: nova_field_attachments_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.nova_field_attachments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: nova_field_attachments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.nova_field_attachments_id_seq OWNED BY public.nova_field_attachments.id;


--
-- Name: nova_notifications; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.nova_notifications (
    id uuid NOT NULL,
    type character varying(255) NOT NULL,
    notifiable_type character varying(255) NOT NULL,
    notifiable_id bigint NOT NULL,
    data text NOT NULL,
    read_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: nova_pending_field_attachments; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.nova_pending_field_attachments (
    id integer NOT NULL,
    draft_id character varying(255) NOT NULL,
    attachment character varying(255) NOT NULL,
    disk character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: nova_pending_field_attachments_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.nova_pending_field_attachments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: nova_pending_field_attachments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.nova_pending_field_attachments_id_seq OWNED BY public.nova_pending_field_attachments.id;


--
-- Name: password_resets; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


--
-- Name: permissions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.permissions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;


--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: podcast_seasons; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.podcast_seasons (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    show_id bigint NOT NULL,
    host_id bigint NOT NULL,
    name json,
    content json,
    status text DEFAULT 'draft'::text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: podcast_seasons_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.podcast_seasons_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: podcast_seasons_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.podcast_seasons_id_seq OWNED BY public.podcast_seasons.id;


--
-- Name: podcast_shows; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.podcast_shows (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    host_id bigint NOT NULL,
    name json,
    content json,
    status text DEFAULT 'draft'::text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: podcast_shows_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.podcast_shows_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: podcast_shows_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.podcast_shows_id_seq OWNED BY public.podcast_shows.id;


--
-- Name: podcasts; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.podcasts (
    id bigint NOT NULL,
    nft_id bigint,
    user_id bigint NOT NULL,
    host_id bigint,
    show_id bigint NOT NULL,
    season_id bigint NOT NULL,
    episode integer NOT NULL,
    youtube_id text NOT NULL,
    published_link text NOT NULL,
    title json NOT NULL,
    meta_title json,
    content json,
    social_excerpt json,
    comment_prompt json,
    recorded_at timestamp(0) without time zone,
    published_at timestamp(0) without time zone,
    status text DEFAULT 'draft'::text NOT NULL,
    length integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: podcasts_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.podcasts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: podcasts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.podcasts_id_seq OWNED BY public.podcasts.id;


--
-- Name: posts; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.posts (
    id bigint NOT NULL,
    parent_id bigint,
    user_id bigint NOT NULL,
    title json NOT NULL,
    meta_title json NOT NULL,
    slug character varying(150) NOT NULL,
    excerpt json,
    content json,
    published_at timestamp without time zone,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    status character varying(30) NOT NULL,
    "order" integer DEFAULT 0 NOT NULL,
    prologue json,
    epilogue json,
    type character varying(255),
    content_audio json,
    comment_prompt json,
    social_excerpt json,
    subtitle json
);


--
-- Name: posts_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.posts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: posts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.posts_id_seq OWNED BY public.posts.id;


--
-- Name: promos; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.promos (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    token_id bigint NOT NULL,
    token_type text NOT NULL,
    uri text,
    title json,
    content json,
    type text DEFAULT 'partner'::text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    status text DEFAULT 'pending'::text NOT NULL
);


--
-- Name: promos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.promos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: promos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.promos_id_seq OWNED BY public.promos.id;


--
-- Name: proposals_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.proposals_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: proposals_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.proposals_id_seq OWNED BY public.proposals.id;


--
-- Name: question_answers; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.question_answers (
    id bigint NOT NULL,
    question_id bigint NOT NULL,
    status text NOT NULL,
    correctness text NOT NULL,
    content json NOT NULL,
    hint json,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: question_answers_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.question_answers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: question_answers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.question_answers_id_seq OWNED BY public.question_answers.id;


--
-- Name: question_quiz; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.question_quiz (
    quiz_id bigint NOT NULL,
    question_id bigint NOT NULL
);


--
-- Name: questions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.questions (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    title json NOT NULL,
    content json NOT NULL,
    type text NOT NULL,
    status text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: questions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.questions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: questions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.questions_id_seq OWNED BY public.questions.id;


--
-- Name: quizzes; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.quizzes (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    title json NOT NULL,
    content json NOT NULL,
    status text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: quizzes_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.quizzes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: quizzes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.quizzes_id_seq OWNED BY public.quizzes.id;


--
-- Name: ratings_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.ratings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: ratings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.ratings_id_seq OWNED BY public.ratings.id;


--
-- Name: reactions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.reactions (
    id bigint NOT NULL,
    commentator_type character varying(255),
    commentator_id bigint,
    comment_id bigint NOT NULL,
    reaction character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: reactions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.reactions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: reactions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.reactions_id_seq OWNED BY public.reactions.id;


--
-- Name: repos; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.repos (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    model_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    url character varying(255) NOT NULL,
    type character varying(255) DEFAULT 'git'::character varying NOT NULL,
    tracked_branch character varying(255) NOT NULL,
    auto_track boolean DEFAULT true NOT NULL,
    deploy_key character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: repos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.repos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: repos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.repos_id_seq OWNED BY public.repos.id;


--
-- Name: rewards; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.rewards (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    stake_address text,
    model_id bigint,
    model_type text,
    asset_type text NOT NULL,
    asset text NOT NULL,
    amount double precision NOT NULL,
    memo json NOT NULL,
    status text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    withdrawal_id bigint,
    wallet_address text
);


--
-- Name: rewards_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.rewards_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: rewards_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.rewards_id_seq OWNED BY public.rewards.id;


--
-- Name: role_has_permissions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.role_has_permissions (
    permission_id bigint NOT NULL,
    role_id bigint NOT NULL
);


--
-- Name: roles; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: rules; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.rules (
    id bigint NOT NULL,
    model_id bigint NOT NULL,
    model_type text NOT NULL,
    subject text NOT NULL,
    predicate text NOT NULL,
    operator text NOT NULL,
    apply_with text NOT NULL,
    type text NOT NULL,
    context text NOT NULL,
    status text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: rules_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.rules_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: rules_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.rules_id_seq OWNED BY public.rules.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


--
-- Name: settings; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.settings (
    id bigint NOT NULL,
    key character varying(255) NOT NULL,
    value json NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: settings_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.settings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.settings_id_seq OWNED BY public.settings.id;


--
-- Name: snippets; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.snippets (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    content json NOT NULL,
    context text NOT NULL,
    type text NOT NULL,
    "order" smallint NOT NULL,
    status text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    preview_url text
);


--
-- Name: snippets_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.snippets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: snippets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.snippets_id_seq OWNED BY public.snippets.id;


--
-- Name: stats; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.stats (
    id bigint NOT NULL,
    key character varying(255) NOT NULL,
    label json NOT NULL,
    value character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: stats_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.stats_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: stats_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.stats_id_seq OWNED BY public.stats.id;


--
-- Name: tags; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.tags (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    meta_title character varying(150) NOT NULL,
    slug character varying(150) NOT NULL,
    content text,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    color text
);


--
-- Name: tags_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.tags_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tags_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.tags_id_seq OWNED BY public.tags.id;


--
-- Name: team_invitations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.team_invitations (
    id bigint NOT NULL,
    team_id bigint NOT NULL,
    email character varying(255) NOT NULL,
    role character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: team_invitations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.team_invitations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: team_invitations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.team_invitations_id_seq OWNED BY public.team_invitations.id;


--
-- Name: team_user; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.team_user (
    id bigint NOT NULL,
    team_id bigint NOT NULL,
    user_id bigint NOT NULL,
    role character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: team_user_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.team_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: team_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.team_user_id_seq OWNED BY public.team_user.id;


--
-- Name: teams; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.teams (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    personal_team boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    excerpt text,
    content text
);


--
-- Name: teams_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.teams_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: teams_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.teams_id_seq OWNED BY public.teams.id;


--
-- Name: telescope_entries; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.telescope_entries (
    sequence bigint NOT NULL,
    uuid uuid NOT NULL,
    batch_id uuid NOT NULL,
    family_hash character varying(255),
    should_display_on_index boolean DEFAULT true NOT NULL,
    type character varying(20) NOT NULL,
    content text NOT NULL,
    created_at timestamp(0) without time zone
);


--
-- Name: telescope_entries_sequence_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.telescope_entries_sequence_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: telescope_entries_sequence_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.telescope_entries_sequence_seq OWNED BY public.telescope_entries.sequence;


--
-- Name: telescope_entries_tags; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.telescope_entries_tags (
    entry_uuid uuid NOT NULL,
    tag character varying(255) NOT NULL
);


--
-- Name: telescope_monitoring; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.telescope_monitoring (
    tag character varying(255) NOT NULL
);


--
-- Name: temporary_files; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.temporary_files (
    id bigint NOT NULL,
    token character varying(255) NOT NULL,
    collection character varying(255) DEFAULT 'default'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: temporary_files_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.temporary_files_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: temporary_files_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.temporary_files_id_seq OWNED BY public.temporary_files.id;


--
-- Name: temporary_uploads; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.temporary_uploads (
    id bigint NOT NULL,
    session_id character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: temporary_uploads_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.temporary_uploads_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: temporary_uploads_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.temporary_uploads_id_seq OWNED BY public.temporary_uploads.id;


--
-- Name: translations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.translations (
    id bigint NOT NULL,
    user_id bigint,
    "group" text,
    key text,
    source_id bigint NOT NULL,
    source_type text NOT NULL,
    source_field text NOT NULL,
    source_content text NOT NULL,
    source_lang text DEFAULT 'en'::character varying NOT NULL,
    lang text NOT NULL,
    content text,
    status text DEFAULT 'draft'::character varying NOT NULL,
    published_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: translations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.translations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: translations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.translations_id_seq OWNED BY public.translations.id;


--
-- Name: twitter_attendances; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.twitter_attendances (
    id bigint NOT NULL,
    twitter_event_id bigint NOT NULL,
    twitter_user_id text NOT NULL,
    user_id bigint,
    stake_address text,
    role text DEFAULT 'audience'::text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: twitter_attendances_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.twitter_attendances_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: twitter_attendances_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.twitter_attendances_id_seq OWNED BY public.twitter_attendances.id;


--
-- Name: twitter_events; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.twitter_events (
    id bigint NOT NULL,
    title text,
    event_id text NOT NULL,
    creator_id text,
    user_id bigint,
    type text DEFAULT 'space'::text NOT NULL,
    participant_count integer,
    subscriber_count integer,
    status text,
    scheduled_at timestamp(0) without time zone,
    started_at timestamp(0) without time zone,
    ended_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    event_post text
);


--
-- Name: twitter_events_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.twitter_events_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: twitter_events_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.twitter_events_id_seq OWNED BY public.twitter_events.id;


--
-- Name: txes; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.txes (
    id bigint NOT NULL,
    user_id bigint,
    model_id bigint NOT NULL,
    model_type text NOT NULL,
    policy text,
    hash text NOT NULL,
    address text,
    status text DEFAULT 'pending'::text NOT NULL,
    quantity double precision,
    metadata json,
    deleted_at timestamp(0) without time zone,
    minted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: txes_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.txes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: txes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.txes_id_seq OWNED BY public.txes.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    current_team_id bigint,
    profile_photo_path text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    two_factor_secret text,
    two_factor_recovery_codes text,
    short_bio text,
    bio text,
    wallet_stake_address character varying(255),
    wallet_address character varying(255),
    wallet_validation_seed_tx character varying(255),
    wallet_validation_seed_index character varying(255),
    wallet_validation_seed_amount character varying(255),
    git text,
    discord text,
    linkedin text,
    telegram text,
    twitter text,
    active_pool_id text,
    lang character varying(255) DEFAULT 'en'::character varying,
    primary_account_id bigint
);


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: view__catalyst_groups; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view__catalyst_groups AS
 SELECT catalyst_groups.id,
    catalyst_groups.user_id,
    catalyst_groups.name,
    (catalyst_groups.bio ->> 'en'::text) AS bio,
    catalyst_groups.website,
    catalyst_groups.twitter,
    catalyst_groups.discord,
    catalyst_groups.github AS experience
   FROM public.catalyst_groups;


--
-- Name: view__proposals; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.view__proposals AS
 SELECT proposals.id,
    proposals.user_id,
    proposals.fund_id,
    (proposals.title ->> 'en'::text) AS title,
    proposals.website,
    proposals.ideascale_link,
    proposals.amount_requested,
    proposals.amount_received,
    proposals.status AS project_status,
    proposals.funding_status,
    proposals.yes_votes_count,
    proposals.no_votes_count,
    proposals.type,
    (proposals.problem ->> 'en'::text) AS problem,
    (proposals.solution ->> 'en'::text) AS solution,
    (proposals.experience ->> 'en'::text) AS experience
   FROM public.proposals;


--
-- Name: votes; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.votes (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    cause_id bigint NOT NULL,
    amount integer NOT NULL,
    memo text,
    status text DEFAULT 'pending'::text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: votes_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.votes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: votes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.votes_id_seq OWNED BY public.votes.id;


--
-- Name: wallets; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.wallets (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    address text,
    verification_key json,
    signing_key json,
    context character varying(255) NOT NULL,
    ada_balance integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    passphrase text,
    wallet_id character varying(255),
    spending_password character varying(255)
);


--
-- Name: wallets_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.wallets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: wallets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.wallets_id_seq OWNED BY public.wallets.id;


--
-- Name: withdrawals; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.withdrawals (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    status text DEFAULT 'processed'::text NOT NULL,
    wallet_address text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


--
-- Name: withdrawals_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.withdrawals_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: withdrawals_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.withdrawals_id_seq OWNED BY public.withdrawals.id;


--
-- Name: action_events id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.action_events ALTER COLUMN id SET DEFAULT nextval('public.action_events_id_seq'::regclass);


--
-- Name: answer_responses id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.answer_responses ALTER COLUMN id SET DEFAULT nextval('public.answer_responses_id_seq'::regclass);


--
-- Name: assessment_reviews id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.assessment_reviews ALTER COLUMN id SET DEFAULT nextval('public.assessment_reviews_id_seq'::regclass);


--
-- Name: assessment_reviews_comments_assessors id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.assessment_reviews_comments_assessors ALTER COLUMN id SET DEFAULT nextval('public.assessment_reviews_comments_assessors_id_seq'::regclass);


--
-- Name: assessors id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.assessors ALTER COLUMN id SET DEFAULT nextval('public.assessors_id_seq'::regclass);


--
-- Name: bookmark_collections id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.bookmark_collections ALTER COLUMN id SET DEFAULT nextval('public.bookmark_collections_id_seq'::regclass);


--
-- Name: bookmark_items id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.bookmark_items ALTER COLUMN id SET DEFAULT nextval('public.bookmark_items_id_seq'::regclass);


--
-- Name: catalyst_groups id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_groups ALTER COLUMN id SET DEFAULT nextval('public.catalyst_groups_id_seq'::regclass);


--
-- Name: catalyst_intents id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_intents ALTER COLUMN id SET DEFAULT nextval('public.catalyst_intents_id_seq'::regclass);


--
-- Name: catalyst_ledger_snapshots id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_ledger_snapshots ALTER COLUMN id SET DEFAULT nextval('public.catalyst_ledger_snapshots_id_seq'::regclass);


--
-- Name: catalyst_ranks id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_ranks ALTER COLUMN id SET DEFAULT nextval('public.catalyst_ranks_id_seq'::regclass);


--
-- Name: catalyst_registrations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_registrations ALTER COLUMN id SET DEFAULT nextval('public.catalyst_registrations_id_seq'::regclass);


--
-- Name: catalyst_reports id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_reports ALTER COLUMN id SET DEFAULT nextval('public.catalyst_reports_id_seq'::regclass);


--
-- Name: catalyst_snapshots id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_snapshots ALTER COLUMN id SET DEFAULT nextval('public.catalyst_snapshots_id_seq'::regclass);


--
-- Name: catalyst_tallies id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_tallies ALTER COLUMN id SET DEFAULT nextval('public.catalyst_tallies_id_seq'::regclass);


--
-- Name: catalyst_users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_users ALTER COLUMN id SET DEFAULT nextval('public.catalyst_users_id_seq'::regclass);


--
-- Name: catalyst_voters id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_voters ALTER COLUMN id SET DEFAULT nextval('public.catalyst_voters_id_seq'::regclass);


--
-- Name: catalyst_votes id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_votes ALTER COLUMN id SET DEFAULT nextval('public.catalyst_votes_id_seq'::regclass);


--
-- Name: catalyst_voting_powers id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_voting_powers ALTER COLUMN id SET DEFAULT nextval('public.catalyst_voting_powers_id_seq'::regclass);


--
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- Name: causes id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.causes ALTER COLUMN id SET DEFAULT nextval('public.causes_id_seq'::regclass);


--
-- Name: ccv4_ballot_choices id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.ccv4_ballot_choices ALTER COLUMN id SET DEFAULT nextval('public.ccv4_ballot_choices_id_seq'::regclass);


--
-- Name: comment_notification_subscriptions id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.comment_notification_subscriptions ALTER COLUMN id SET DEFAULT nextval('public.comment_notification_subscriptions_id_seq'::regclass);


--
-- Name: comments id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.comments ALTER COLUMN id SET DEFAULT nextval('public.comments_id_seq1'::regclass);


--
-- Name: commits id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.commits ALTER COLUMN id SET DEFAULT nextval('public.commits_id_seq'::regclass);


--
-- Name: courses id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.courses ALTER COLUMN id SET DEFAULT nextval('public.courses_id_seq'::regclass);


--
-- Name: definitions id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.definitions ALTER COLUMN id SET DEFAULT nextval('public.definitions_id_seq'::regclass);


--
-- Name: delegations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.delegations ALTER COLUMN id SET DEFAULT nextval('public.delegations_id_seq'::regclass);


--
-- Name: discussions id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.discussions ALTER COLUMN id SET DEFAULT nextval('public.discussions_id_seq'::regclass);


--
-- Name: events id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.events ALTER COLUMN id SET DEFAULT nextval('public.events_id_seq'::regclass);


--
-- Name: every_epochs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.every_epochs ALTER COLUMN id SET DEFAULT nextval('public.every_epochs_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: flags id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.flags ALTER COLUMN id SET DEFAULT nextval('public.flags_id_seq'::regclass);


--
-- Name: funds id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.funds ALTER COLUMN id SET DEFAULT nextval('public.funds_id_seq'::regclass);


--
-- Name: giveaway_model id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.giveaway_model ALTER COLUMN id SET DEFAULT nextval('public.giveaway_model_id_seq'::regclass);


--
-- Name: giveaways id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.giveaways ALTER COLUMN id SET DEFAULT nextval('public.giveaways_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: language_lines id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.language_lines ALTER COLUMN id SET DEFAULT nextval('public.language_lines_id_seq'::regclass);


--
-- Name: learning_attempts id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.learning_attempts ALTER COLUMN id SET DEFAULT nextval('public.learning_attempts_id_seq'::regclass);


--
-- Name: learning_lessons id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.learning_lessons ALTER COLUMN id SET DEFAULT nextval('public.learning_lessons_id_seq'::regclass);


--
-- Name: learning_modules id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.learning_modules ALTER COLUMN id SET DEFAULT nextval('public.learning_modules_id_seq'::regclass);


--
-- Name: learning_topics id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.learning_topics ALTER COLUMN id SET DEFAULT nextval('public.learning_topics_id_seq'::regclass);


--
-- Name: legacy_comments id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.legacy_comments ALTER COLUMN id SET DEFAULT nextval('public.comments_id_seq'::regclass);


--
-- Name: lesson_post id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.lesson_post ALTER COLUMN id SET DEFAULT nextval('public.lesson_post_id_seq'::regclass);


--
-- Name: lessons id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.lessons ALTER COLUMN id SET DEFAULT nextval('public.lessons_id_seq'::regclass);


--
-- Name: lido_reactions id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.lido_reactions ALTER COLUMN id SET DEFAULT nextval('public.lido_reactions_id_seq'::regclass);


--
-- Name: links id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.links ALTER COLUMN id SET DEFAULT nextval('public.links_id_seq'::regclass);


--
-- Name: media id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.media ALTER COLUMN id SET DEFAULT nextval('public.media_id_seq'::regclass);


--
-- Name: metas id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.metas ALTER COLUMN id SET DEFAULT nextval('public.metas_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: mint_txes id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.mint_txes ALTER COLUMN id SET DEFAULT nextval('public.mint_txes_id_seq'::regclass);


--
-- Name: mints id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.mints ALTER COLUMN id SET DEFAULT nextval('public.mints_id_seq'::regclass);


--
-- Name: model_categories id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_categories ALTER COLUMN id SET DEFAULT nextval('public.model_categories_id_seq'::regclass);


--
-- Name: model_links id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_links ALTER COLUMN id SET DEFAULT nextval('public.model_links_id_seq'::regclass);


--
-- Name: model_quiz id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_quiz ALTER COLUMN id SET DEFAULT nextval('public.model_quiz_id_seq'::regclass);


--
-- Name: model_snippets id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_snippets ALTER COLUMN id SET DEFAULT nextval('public.model_snippets_id_seq'::regclass);


--
-- Name: model_tags id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_tags ALTER COLUMN id SET DEFAULT nextval('public.model_tags_id_seq'::regclass);


--
-- Name: model_wallets id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_wallets ALTER COLUMN id SET DEFAULT nextval('public.model_wallets_id_seq'::regclass);


--
-- Name: nfts id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.nfts ALTER COLUMN id SET DEFAULT nextval('public.nfts_id_seq'::regclass);


--
-- Name: notification_request_templates id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.notification_request_templates ALTER COLUMN id SET DEFAULT nextval('public.notification_request_templates_id_seq'::regclass);


--
-- Name: notification_requests id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.notification_requests ALTER COLUMN id SET DEFAULT nextval('public.notification_requests_id_seq'::regclass);


--
-- Name: nova_field_attachments id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.nova_field_attachments ALTER COLUMN id SET DEFAULT nextval('public.nova_field_attachments_id_seq'::regclass);


--
-- Name: nova_pending_field_attachments id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.nova_pending_field_attachments ALTER COLUMN id SET DEFAULT nextval('public.nova_pending_field_attachments_id_seq'::regclass);


--
-- Name: permissions id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: podcast_seasons id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.podcast_seasons ALTER COLUMN id SET DEFAULT nextval('public.podcast_seasons_id_seq'::regclass);


--
-- Name: podcast_shows id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.podcast_shows ALTER COLUMN id SET DEFAULT nextval('public.podcast_shows_id_seq'::regclass);


--
-- Name: podcasts id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.podcasts ALTER COLUMN id SET DEFAULT nextval('public.podcasts_id_seq'::regclass);


--
-- Name: posts id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.posts ALTER COLUMN id SET DEFAULT nextval('public.posts_id_seq'::regclass);


--
-- Name: promos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.promos ALTER COLUMN id SET DEFAULT nextval('public.promos_id_seq'::regclass);


--
-- Name: proposals id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.proposals ALTER COLUMN id SET DEFAULT nextval('public.proposals_id_seq'::regclass);


--
-- Name: question_answers id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.question_answers ALTER COLUMN id SET DEFAULT nextval('public.question_answers_id_seq'::regclass);


--
-- Name: questions id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.questions ALTER COLUMN id SET DEFAULT nextval('public.questions_id_seq'::regclass);


--
-- Name: quizzes id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.quizzes ALTER COLUMN id SET DEFAULT nextval('public.quizzes_id_seq'::regclass);


--
-- Name: ratings id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.ratings ALTER COLUMN id SET DEFAULT nextval('public.ratings_id_seq'::regclass);


--
-- Name: reactions id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.reactions ALTER COLUMN id SET DEFAULT nextval('public.reactions_id_seq'::regclass);


--
-- Name: repos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.repos ALTER COLUMN id SET DEFAULT nextval('public.repos_id_seq'::regclass);


--
-- Name: rewards id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.rewards ALTER COLUMN id SET DEFAULT nextval('public.rewards_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: rules id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.rules ALTER COLUMN id SET DEFAULT nextval('public.rules_id_seq'::regclass);


--
-- Name: settings id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.settings ALTER COLUMN id SET DEFAULT nextval('public.settings_id_seq'::regclass);


--
-- Name: snippets id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.snippets ALTER COLUMN id SET DEFAULT nextval('public.snippets_id_seq'::regclass);


--
-- Name: stats id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.stats ALTER COLUMN id SET DEFAULT nextval('public.stats_id_seq'::regclass);


--
-- Name: tags id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tags ALTER COLUMN id SET DEFAULT nextval('public.tags_id_seq'::regclass);


--
-- Name: team_invitations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.team_invitations ALTER COLUMN id SET DEFAULT nextval('public.team_invitations_id_seq'::regclass);


--
-- Name: team_user id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.team_user ALTER COLUMN id SET DEFAULT nextval('public.team_user_id_seq'::regclass);


--
-- Name: teams id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.teams ALTER COLUMN id SET DEFAULT nextval('public.teams_id_seq'::regclass);


--
-- Name: telescope_entries sequence; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.telescope_entries ALTER COLUMN sequence SET DEFAULT nextval('public.telescope_entries_sequence_seq'::regclass);


--
-- Name: temporary_files id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.temporary_files ALTER COLUMN id SET DEFAULT nextval('public.temporary_files_id_seq'::regclass);


--
-- Name: temporary_uploads id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.temporary_uploads ALTER COLUMN id SET DEFAULT nextval('public.temporary_uploads_id_seq'::regclass);


--
-- Name: translations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.translations ALTER COLUMN id SET DEFAULT nextval('public.translations_id_seq'::regclass);


--
-- Name: twitter_attendances id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.twitter_attendances ALTER COLUMN id SET DEFAULT nextval('public.twitter_attendances_id_seq'::regclass);


--
-- Name: twitter_events id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.twitter_events ALTER COLUMN id SET DEFAULT nextval('public.twitter_events_id_seq'::regclass);


--
-- Name: txes id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.txes ALTER COLUMN id SET DEFAULT nextval('public.txes_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: votes id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.votes ALTER COLUMN id SET DEFAULT nextval('public.votes_id_seq'::regclass);


--
-- Name: wallets id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.wallets ALTER COLUMN id SET DEFAULT nextval('public.wallets_id_seq'::regclass);


--
-- Name: withdrawals id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.withdrawals ALTER COLUMN id SET DEFAULT nextval('public.withdrawals_id_seq'::regclass);


--
-- Name: action_events action_events_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.action_events
    ADD CONSTRAINT action_events_pkey PRIMARY KEY (id);


--
-- Name: anonymous_bookmarks anonymous_bookmarks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.anonymous_bookmarks
    ADD CONSTRAINT anonymous_bookmarks_pkey PRIMARY KEY (id);


--
-- Name: answer_responses answer_responses_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.answer_responses
    ADD CONSTRAINT answer_responses_pkey PRIMARY KEY (id);


--
-- Name: assessment_reviews_comments_assessors assessment_reviews_comments_assessors_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.assessment_reviews_comments_assessors
    ADD CONSTRAINT assessment_reviews_comments_assessors_pkey PRIMARY KEY (id);


--
-- Name: assessment_reviews assessment_reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.assessment_reviews
    ADD CONSTRAINT assessment_reviews_pkey PRIMARY KEY (id);


--
-- Name: assessors assessors_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.assessors
    ADD CONSTRAINT assessors_pkey PRIMARY KEY (id);


--
-- Name: bookmark_collections bookmark_collections_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.bookmark_collections
    ADD CONSTRAINT bookmark_collections_pkey PRIMARY KEY (id);


--
-- Name: bookmark_items bookmark_items_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.bookmark_items
    ADD CONSTRAINT bookmark_items_pkey PRIMARY KEY (id);


--
-- Name: catalyst_groups catalyst_groups_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_groups
    ADD CONSTRAINT catalyst_groups_pkey PRIMARY KEY (id);


--
-- Name: catalyst_intents catalyst_intents_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_intents
    ADD CONSTRAINT catalyst_intents_pkey PRIMARY KEY (id);


--
-- Name: catalyst_ledger_snapshots catalyst_ledger_snapshots_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_ledger_snapshots
    ADD CONSTRAINT catalyst_ledger_snapshots_pkey PRIMARY KEY (id);


--
-- Name: catalyst_ledger_snapshots catalyst_ledger_snapshots_snapshot_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_ledger_snapshots
    ADD CONSTRAINT catalyst_ledger_snapshots_snapshot_id_unique UNIQUE (snapshot_id);


--
-- Name: catalyst_ranks catalyst_ranks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_ranks
    ADD CONSTRAINT catalyst_ranks_pkey PRIMARY KEY (id);


--
-- Name: catalyst_registrations catalyst_registrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_registrations
    ADD CONSTRAINT catalyst_registrations_pkey PRIMARY KEY (id);


--
-- Name: catalyst_reports catalyst_reports_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_reports
    ADD CONSTRAINT catalyst_reports_pkey PRIMARY KEY (id);


--
-- Name: catalyst_snapshots catalyst_snapshots_model_id_model_type_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_snapshots
    ADD CONSTRAINT catalyst_snapshots_model_id_model_type_unique UNIQUE (model_id, model_type);


--
-- Name: catalyst_snapshots catalyst_snapshots_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_snapshots
    ADD CONSTRAINT catalyst_snapshots_pkey PRIMARY KEY (id);


--
-- Name: catalyst_tallies catalyst_tallies_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_tallies
    ADD CONSTRAINT catalyst_tallies_pkey PRIMARY KEY (id);


--
-- Name: catalyst_users catalyst_users_email_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_users
    ADD CONSTRAINT catalyst_users_email_unique UNIQUE (email);


--
-- Name: catalyst_users catalyst_users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_users
    ADD CONSTRAINT catalyst_users_pkey PRIMARY KEY (id);


--
-- Name: catalyst_users catalyst_users_username_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_users
    ADD CONSTRAINT catalyst_users_username_unique UNIQUE (username);


--
-- Name: catalyst_voters catalyst_voters_index; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_voters
    ADD CONSTRAINT catalyst_voters_index UNIQUE (stake_key, voting_key, cat_id);


--
-- Name: catalyst_voters catalyst_voters_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_voters
    ADD CONSTRAINT catalyst_voters_pkey PRIMARY KEY (id);


--
-- Name: catalyst_votes catalyst_votes_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_votes
    ADD CONSTRAINT catalyst_votes_pkey PRIMARY KEY (id);


--
-- Name: catalyst_voting_powers catalyst_voting_powers_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_voting_powers
    ADD CONSTRAINT catalyst_voting_powers_pkey PRIMARY KEY (id);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: causes causes_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.causes
    ADD CONSTRAINT causes_pkey PRIMARY KEY (id);


--
-- Name: ccv4_ballot_choices ccv4_ballot_choices_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.ccv4_ballot_choices
    ADD CONSTRAINT ccv4_ballot_choices_pkey PRIMARY KEY (id);


--
-- Name: comment_notification_subscriptions comment_notification_subscriptions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.comment_notification_subscriptions
    ADD CONSTRAINT comment_notification_subscriptions_pkey PRIMARY KEY (id);


--
-- Name: legacy_comments comments_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.legacy_comments
    ADD CONSTRAINT comments_pkey PRIMARY KEY (id);


--
-- Name: comments comments_pkey1; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.comments
    ADD CONSTRAINT comments_pkey1 PRIMARY KEY (id);


--
-- Name: commits commits_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.commits
    ADD CONSTRAINT commits_pkey PRIMARY KEY (id);


--
-- Name: courses courses_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT courses_pkey PRIMARY KEY (id);


--
-- Name: courses courses_title_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT courses_title_unique UNIQUE (title);


--
-- Name: definitions definitions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.definitions
    ADD CONSTRAINT definitions_pkey PRIMARY KEY (id);


--
-- Name: delegations delegations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.delegations
    ADD CONSTRAINT delegations_pkey PRIMARY KEY (id);


--
-- Name: discussions discussions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.discussions
    ADD CONSTRAINT discussions_pkey PRIMARY KEY (id);


--
-- Name: events events_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);


--
-- Name: every_epochs every_epochs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.every_epochs
    ADD CONSTRAINT every_epochs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: flags flags_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.flags
    ADD CONSTRAINT flags_pkey PRIMARY KEY (id);


--
-- Name: funds funds_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.funds
    ADD CONSTRAINT funds_pkey PRIMARY KEY (id);


--
-- Name: giveaway_model giveaway_model_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.giveaway_model
    ADD CONSTRAINT giveaway_model_pkey PRIMARY KEY (id);


--
-- Name: giveaways giveaways_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.giveaways
    ADD CONSTRAINT giveaways_pkey PRIMARY KEY (id);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: language_lines language_lines_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.language_lines
    ADD CONSTRAINT language_lines_pkey PRIMARY KEY (id);


--
-- Name: learning_attempts learning_attempts_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.learning_attempts
    ADD CONSTRAINT learning_attempts_pkey PRIMARY KEY (id);


--
-- Name: learning_lessons learning_lessons_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.learning_lessons
    ADD CONSTRAINT learning_lessons_pkey PRIMARY KEY (id);


--
-- Name: learning_modules learning_modules_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.learning_modules
    ADD CONSTRAINT learning_modules_pkey PRIMARY KEY (id);


--
-- Name: learning_topics learning_topics_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.learning_topics
    ADD CONSTRAINT learning_topics_pkey PRIMARY KEY (id);


--
-- Name: lesson_post lesson_post_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.lesson_post
    ADD CONSTRAINT lesson_post_pkey PRIMARY KEY (id);


--
-- Name: lessons lessons_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.lessons
    ADD CONSTRAINT lessons_pkey PRIMARY KEY (id);


--
-- Name: lido_reactions lido_reactions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.lido_reactions
    ADD CONSTRAINT lido_reactions_pkey PRIMARY KEY (id);


--
-- Name: links links_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.links
    ADD CONSTRAINT links_pkey PRIMARY KEY (id);


--
-- Name: media media_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.media
    ADD CONSTRAINT media_pkey PRIMARY KEY (id);


--
-- Name: media media_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.media
    ADD CONSTRAINT media_uuid_unique UNIQUE (uuid);


--
-- Name: metas metas_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.metas
    ADD CONSTRAINT metas_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: mint_txes mint_txes_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.mint_txes
    ADD CONSTRAINT mint_txes_pkey PRIMARY KEY (id);


--
-- Name: mints mints_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.mints
    ADD CONSTRAINT mints_pkey PRIMARY KEY (id);


--
-- Name: model_categories model_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_categories
    ADD CONSTRAINT model_categories_pkey PRIMARY KEY (id);


--
-- Name: model_has_permissions model_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_pkey PRIMARY KEY (permission_id, model_id, model_type);


--
-- Name: model_has_roles model_has_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_pkey PRIMARY KEY (role_id, model_id, model_type);


--
-- Name: model_links model_links_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_links
    ADD CONSTRAINT model_links_pkey PRIMARY KEY (id);


--
-- Name: model_quiz model_quiz_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_quiz
    ADD CONSTRAINT model_quiz_pkey PRIMARY KEY (id);


--
-- Name: model_snippets model_snippets_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_snippets
    ADD CONSTRAINT model_snippets_pkey PRIMARY KEY (id);


--
-- Name: model_tags model_tags_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_tags
    ADD CONSTRAINT model_tags_pkey PRIMARY KEY (id);


--
-- Name: model_wallets model_wallets_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_wallets
    ADD CONSTRAINT model_wallets_pkey PRIMARY KEY (id);


--
-- Name: nfts nfts_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.nfts
    ADD CONSTRAINT nfts_pkey PRIMARY KEY (id);


--
-- Name: notification_request_templates notification_request_templates_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.notification_request_templates
    ADD CONSTRAINT notification_request_templates_pkey PRIMARY KEY (id);


--
-- Name: notification_requests notification_requests_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.notification_requests
    ADD CONSTRAINT notification_requests_pkey PRIMARY KEY (id);


--
-- Name: nova_field_attachments nova_field_attachments_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.nova_field_attachments
    ADD CONSTRAINT nova_field_attachments_pkey PRIMARY KEY (id);


--
-- Name: nova_notifications nova_notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.nova_notifications
    ADD CONSTRAINT nova_notifications_pkey PRIMARY KEY (id);


--
-- Name: nova_pending_field_attachments nova_pending_field_attachments_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.nova_pending_field_attachments
    ADD CONSTRAINT nova_pending_field_attachments_pkey PRIMARY KEY (id);


--
-- Name: permissions permissions_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: podcast_seasons podcast_seasons_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.podcast_seasons
    ADD CONSTRAINT podcast_seasons_pkey PRIMARY KEY (id);


--
-- Name: podcast_shows podcast_shows_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.podcast_shows
    ADD CONSTRAINT podcast_shows_pkey PRIMARY KEY (id);


--
-- Name: podcasts podcasts_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.podcasts
    ADD CONSTRAINT podcasts_pkey PRIMARY KEY (id);


--
-- Name: posts posts_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.posts
    ADD CONSTRAINT posts_pkey PRIMARY KEY (id);


--
-- Name: posts posts_slug_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.posts
    ADD CONSTRAINT posts_slug_unique UNIQUE (slug);


--
-- Name: promos promos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.promos
    ADD CONSTRAINT promos_pkey PRIMARY KEY (id);


--
-- Name: proposals proposals_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.proposals
    ADD CONSTRAINT proposals_pkey PRIMARY KEY (id);


--
-- Name: question_answers question_answers_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.question_answers
    ADD CONSTRAINT question_answers_pkey PRIMARY KEY (id);


--
-- Name: questions questions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_pkey PRIMARY KEY (id);


--
-- Name: quizzes quizzes_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.quizzes
    ADD CONSTRAINT quizzes_pkey PRIMARY KEY (id);


--
-- Name: ratings ratings_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.ratings
    ADD CONSTRAINT ratings_pkey PRIMARY KEY (id);


--
-- Name: reactions reactions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.reactions
    ADD CONSTRAINT reactions_pkey PRIMARY KEY (id);


--
-- Name: repos repos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.repos
    ADD CONSTRAINT repos_pkey PRIMARY KEY (id);


--
-- Name: rewards rewards_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.rewards
    ADD CONSTRAINT rewards_pkey PRIMARY KEY (id);


--
-- Name: role_has_permissions role_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_pkey PRIMARY KEY (permission_id, role_id);


--
-- Name: roles roles_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: rules rules_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.rules
    ADD CONSTRAINT rules_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: settings settings_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_pkey PRIMARY KEY (id);


--
-- Name: snippets snippets_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.snippets
    ADD CONSTRAINT snippets_pkey PRIMARY KEY (id);


--
-- Name: stats stats_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.stats
    ADD CONSTRAINT stats_pkey PRIMARY KEY (id);


--
-- Name: tags tags_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tags
    ADD CONSTRAINT tags_pkey PRIMARY KEY (id);


--
-- Name: team_invitations team_invitations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.team_invitations
    ADD CONSTRAINT team_invitations_pkey PRIMARY KEY (id);


--
-- Name: team_invitations team_invitations_team_id_email_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.team_invitations
    ADD CONSTRAINT team_invitations_team_id_email_unique UNIQUE (team_id, email);


--
-- Name: team_user team_user_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.team_user
    ADD CONSTRAINT team_user_pkey PRIMARY KEY (id);


--
-- Name: team_user team_user_team_id_user_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.team_user
    ADD CONSTRAINT team_user_team_id_user_id_unique UNIQUE (team_id, user_id);


--
-- Name: teams teams_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.teams
    ADD CONSTRAINT teams_pkey PRIMARY KEY (id);


--
-- Name: telescope_entries telescope_entries_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.telescope_entries
    ADD CONSTRAINT telescope_entries_pkey PRIMARY KEY (sequence);


--
-- Name: telescope_entries telescope_entries_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.telescope_entries
    ADD CONSTRAINT telescope_entries_uuid_unique UNIQUE (uuid);


--
-- Name: temporary_files temporary_files_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.temporary_files
    ADD CONSTRAINT temporary_files_pkey PRIMARY KEY (id);


--
-- Name: temporary_uploads temporary_uploads_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.temporary_uploads
    ADD CONSTRAINT temporary_uploads_pkey PRIMARY KEY (id);


--
-- Name: translations translations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.translations
    ADD CONSTRAINT translations_pkey PRIMARY KEY (id);


--
-- Name: twitter_attendances twitter_attendances_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.twitter_attendances
    ADD CONSTRAINT twitter_attendances_pkey PRIMARY KEY (id);


--
-- Name: twitter_events twitter_events_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.twitter_events
    ADD CONSTRAINT twitter_events_pkey PRIMARY KEY (id);


--
-- Name: txes txes_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.txes
    ADD CONSTRAINT txes_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: votes votes_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.votes
    ADD CONSTRAINT votes_pkey PRIMARY KEY (id);


--
-- Name: wallets wallets_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.wallets
    ADD CONSTRAINT wallets_pkey PRIMARY KEY (id);


--
-- Name: withdrawals withdrawals_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.withdrawals
    ADD CONSTRAINT withdrawals_pkey PRIMARY KEY (id);


--
-- Name: action_events_actionable_type_actionable_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX action_events_actionable_type_actionable_id_index ON public.action_events USING btree (actionable_type, actionable_id);


--
-- Name: action_events_batch_id_model_type_model_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX action_events_batch_id_model_type_model_id_index ON public.action_events USING btree (batch_id, model_type, model_id);


--
-- Name: action_events_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX action_events_user_id_index ON public.action_events USING btree (user_id);


--
-- Name: cat_onchain_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cat_onchain_id_index ON public.delegations USING btree (cat_onchain_id);


--
-- Name: catalyst_groups_slug_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX catalyst_groups_slug_index ON public.catalyst_groups USING btree (slug);


--
-- Name: catalyst_groups_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX catalyst_groups_user_id_index ON public.catalyst_groups USING btree (user_id);


--
-- Name: catalyst_intents_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX catalyst_intents_user_id_index ON public.catalyst_intents USING btree (user_id);


--
-- Name: catalyst_reports_content_fulltext; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX catalyst_reports_content_fulltext ON public.catalyst_reports USING gin (to_tsvector('english'::regconfig, content));


--
-- Name: catalyst_reports_proposal_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX catalyst_reports_proposal_id_index ON public.catalyst_reports USING btree (proposal_id);


--
-- Name: catalyst_users_claimed_by_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX catalyst_users_claimed_by_index ON public.catalyst_users USING btree (claimed_by);


--
-- Name: catalyst_users_name_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX catalyst_users_name_index ON public.catalyst_users USING btree (name);


--
-- Name: catalyst_users_username_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX catalyst_users_username_index ON public.catalyst_users USING btree (username);


--
-- Name: categories_content_fulltext; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX categories_content_fulltext ON public.categories USING gin (to_tsvector('english'::regconfig, content));


--
-- Name: categories_title_fulltext; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX categories_title_fulltext ON public.categories USING gin (to_tsvector('english'::regconfig, (title)::text));


--
-- Name: cn_subscriptions_commentable; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cn_subscriptions_commentable ON public.comment_notification_subscriptions USING btree (commentable_type, commentable_id);


--
-- Name: cn_subscriptions_subscriber; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cn_subscriptions_subscriber ON public.comment_notification_subscriptions USING btree (subscriber_type, subscriber_id);


--
-- Name: commentator_comments; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX commentator_comments ON public.comments USING btree (commentator_type, commentator_id);


--
-- Name: commentator_reactions; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX commentator_reactions ON public.reactions USING btree (commentator_type, commentator_id);


--
-- Name: comments_commentable_type_commentable_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX comments_commentable_type_commentable_id_index ON public.comments USING btree (commentable_type, commentable_id);


--
-- Name: comments_model_type_model_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX comments_model_type_model_id_index ON public.legacy_comments USING btree (model_type, model_id);


--
-- Name: discussions_model_id_model_type_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX discussions_model_id_model_type_index ON public.discussions USING btree (model_id, model_type);


--
-- Name: funds_slug_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX funds_slug_index ON public.funds USING btree (slug);


--
-- Name: funds_title_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX funds_title_index ON public.funds USING btree (title);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: language_lines_group_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX language_lines_group_index ON public.language_lines USING btree ("group");


--
-- Name: links_link_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX links_link_index ON public.links USING btree (link);


--
-- Name: media_model_type_model_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX media_model_type_model_id_index ON public.media USING btree (model_type, model_id);


--
-- Name: metas_key_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX metas_key_index ON public.metas USING btree (key);


--
-- Name: metas_model_type_model_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX metas_model_type_model_id_index ON public.metas USING btree (model_type, model_id);


--
-- Name: model_categories_model_type_model_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX model_categories_model_type_model_id_index ON public.model_categories USING btree (model_type, model_id);


--
-- Name: model_has_permissions_model_id_model_type_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX model_has_permissions_model_id_model_type_index ON public.model_has_permissions USING btree (model_id, model_type);


--
-- Name: model_has_roles_model_id_model_type_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX model_has_roles_model_id_model_type_index ON public.model_has_roles USING btree (model_id, model_type);


--
-- Name: model_links_model_id_link_id_model_type_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX model_links_model_id_link_id_model_type_index ON public.model_links USING btree (model_id, link_id, model_type);


--
-- Name: model_snippets_model_id_snippet_id_model_type_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX model_snippets_model_id_snippet_id_model_type_index ON public.model_snippets USING btree (model_id, snippet_id, model_type);


--
-- Name: model_tags_model_type_model_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX model_tags_model_type_model_id_index ON public.model_tags USING btree (model_type, model_id);


--
-- Name: nova_field_attachments_attachable_type_attachable_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX nova_field_attachments_attachable_type_attachable_id_index ON public.nova_field_attachments USING btree (attachable_type, attachable_id);


--
-- Name: nova_field_attachments_url_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX nova_field_attachments_url_index ON public.nova_field_attachments USING btree (url);


--
-- Name: nova_notifications_notifiable_type_notifiable_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX nova_notifications_notifiable_type_notifiable_id_index ON public.nova_notifications USING btree (notifiable_type, notifiable_id);


--
-- Name: nova_pending_field_attachments_draft_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX nova_pending_field_attachments_draft_id_index ON public.nova_pending_field_attachments USING btree (draft_id);


--
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: posts_status_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX posts_status_index ON public.posts USING btree (status);


--
-- Name: proposals_fund_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX proposals_fund_id_index ON public.proposals USING btree (fund_id);


--
-- Name: proposals_slug_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX proposals_slug_index ON public.proposals USING btree (slug);


--
-- Name: proposals_team_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX proposals_team_id_index ON public.proposals USING btree (team_id);


--
-- Name: proposals_title_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX proposals_title_index ON public.proposals USING gin (title jsonb_path_ops);


--
-- Name: proposals_type_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX proposals_type_index ON public.proposals USING btree (type);


--
-- Name: ratings_model_id_model_type_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX ratings_model_id_model_type_index ON public.ratings USING btree (model_id, model_type);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: tags_content_fulltext; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX tags_content_fulltext ON public.tags USING gin (to_tsvector('english'::regconfig, content));


--
-- Name: tags_title_fulltext; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX tags_title_fulltext ON public.tags USING gin (to_tsvector('english'::regconfig, (title)::text));


--
-- Name: teams_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX teams_user_id_index ON public.teams USING btree (user_id);


--
-- Name: telescope_entries_batch_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX telescope_entries_batch_id_index ON public.telescope_entries USING btree (batch_id);


--
-- Name: telescope_entries_created_at_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX telescope_entries_created_at_index ON public.telescope_entries USING btree (created_at);


--
-- Name: telescope_entries_family_hash_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX telescope_entries_family_hash_index ON public.telescope_entries USING btree (family_hash);


--
-- Name: telescope_entries_tags_entry_uuid_tag_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX telescope_entries_tags_entry_uuid_tag_index ON public.telescope_entries_tags USING btree (entry_uuid, tag);


--
-- Name: telescope_entries_tags_tag_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX telescope_entries_tags_tag_index ON public.telescope_entries_tags USING btree (tag);


--
-- Name: telescope_entries_type_should_display_on_index_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX telescope_entries_type_should_display_on_index_index ON public.telescope_entries USING btree (type, should_display_on_index);


--
-- Name: users_name_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX users_name_index ON public.users USING btree (name);


--
-- Name: voter_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX voter_id_index ON public.catalyst_voting_powers USING btree (voter_id);


--
-- Name: bookmark_items bookmark_items_bookmark_collection_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.bookmark_items
    ADD CONSTRAINT bookmark_items_bookmark_collection_id_foreign FOREIGN KEY (bookmark_collection_id) REFERENCES public.bookmark_collections(id) ON DELETE CASCADE;


--
-- Name: catalyst_ranks catalyst_ranks_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_ranks
    ADD CONSTRAINT catalyst_ranks_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: catalyst_votes catalyst_votes_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_votes
    ADD CONSTRAINT catalyst_votes_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: catalyst_voting_powers catalyst_voting_powers_catalyst_snapshot_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.catalyst_voting_powers
    ADD CONSTRAINT catalyst_voting_powers_catalyst_snapshot_id_foreign FOREIGN KEY (catalyst_snapshot_id) REFERENCES public.catalyst_snapshots(id);


--
-- Name: comments comments_parent_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.comments
    ADD CONSTRAINT comments_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES public.comments(id) ON DELETE CASCADE;


--
-- Name: delegations delegations_catalyst_registration_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.delegations
    ADD CONSTRAINT delegations_catalyst_registration_id_foreign FOREIGN KEY (catalyst_registration_id) REFERENCES public.catalyst_registrations(id);


--
-- Name: lesson_post lesson_post_lesson_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.lesson_post
    ADD CONSTRAINT lesson_post_lesson_id_foreign FOREIGN KEY (lesson_id) REFERENCES public.lessons(id);


--
-- Name: lesson_post lesson_post_post_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.lesson_post
    ADD CONSTRAINT lesson_post_post_id_foreign FOREIGN KEY (post_id) REFERENCES public.posts(id);


--
-- Name: lessons lessons_course_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.lessons
    ADD CONSTRAINT lessons_course_id_foreign FOREIGN KEY (course_id) REFERENCES public.courses(id);


--
-- Name: lessons lessons_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.lessons
    ADD CONSTRAINT lessons_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: model_has_permissions model_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: model_has_roles model_has_roles_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: reactions reactions_comment_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.reactions
    ADD CONSTRAINT reactions_comment_id_foreign FOREIGN KEY (comment_id) REFERENCES public.comments(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: team_invitations team_invitations_team_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.team_invitations
    ADD CONSTRAINT team_invitations_team_id_foreign FOREIGN KEY (team_id) REFERENCES public.teams(id) ON DELETE CASCADE;


--
-- Name: telescope_entries_tags telescope_entries_tags_entry_uuid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.telescope_entries_tags
    ADD CONSTRAINT telescope_entries_tags_entry_uuid_foreign FOREIGN KEY (entry_uuid) REFERENCES public.telescope_entries(uuid) ON DELETE CASCADE;


--
-- Name: twitter_attendances twitter_attendances_twitter_event_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.twitter_attendances
    ADD CONSTRAINT twitter_attendances_twitter_event_id_foreign FOREIGN KEY (twitter_event_id) REFERENCES public.twitter_events(id) ON DELETE SET NULL;


--
-- Name: users users_primary_account_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_primary_account_id_foreign FOREIGN KEY (primary_account_id) REFERENCES public.users(id);


--
-- PostgreSQL database dump complete
--

--
-- PostgreSQL database dump
--

-- Dumped from database version 15.2
-- Dumped by pg_dump version 15.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2014_10_12_000000_create_users_table	1
2	2014_10_12_100000_create_password_resets_table	1
3	2014_10_12_200000_add_two_factor_columns_to_users_table	1
4	2018_01_01_000000_create_action_events_table	1
5	2018_08_08_100000_create_telescope_entries_table	1
6	2019_05_10_000000_add_fields_to_action_events_table	1
7	2019_08_19_000000_create_failed_jobs_table	1
8	2019_12_14_000001_create_personal_access_tokens_table	1
9	2020_05_21_100000_create_teams_table	1
10	2020_05_21_200000_create_team_user_table	1
11	2020_05_21_300000_create_team_invitations_table	1
12	2020_06_03_131044_create_temporary_files_table	1
13	2020_11_21_060333_create_sessions_table	1
14	2021_02_19_051035_create_permission_tables	1
15	2021_02_21_063002_create_posts_table	1
16	2021_02_21_070146_create_categories_table	1
17	2021_02_25_195138_create_comments_table	1
18	2021_02_25_195227_create_metas_table	1
19	2021_02_25_200900_create_tags_table	1
20	2021_02_25_201141_create_model_categories_table	1
21	2021_02_25_201157_create_model_tags_table	1
22	2021_02_26_000742_add_status_column_to_posts	1
23	2021_02_26_002027_create_media_table	1
24	2021_02_27_173555_make_comment_title_nullable	1
25	2021_02_28_014810_post_order	1
26	2021_03_05_034112_add_prologue_and_epilogue_to_posts_table	1
27	2021_03_23_112620_create_definitions_table	1
28	2021_05_21_034450_add_type_to_posts	1
29	2021_05_21_040405_set_model_types	1
30	2021_05_25_120541_make_posts_slug_column_unique	1
31	2021_06_13_023456_create_language_lines_table	1
32	2021_06_27_041121_rename_comment_author_id_to_user_id	1
33	2021_06_27_041555_add_status_to_comments_table	1
34	2021_07_04_042022_add-audio-content-to-posts	1
35	2021_07_06_042022_posts_title_column	1
36	2021_07_12_040558_add_comment_prompt_and_social_excerpt_to_posts_table	1
37	2021_07_20_043954_add_bio_to_users_table	1
38	2021_07_21_212954_create_proposals_table	1
39	2021_07_23_035022_add_yes_votes_count_and_no_votes_count_to_proposals_table	1
40	2021_07_23_043903_rename_url_column_on_proposals_table	1
41	2021_07_24_042202_create_funds_table	1
42	2021_07_24_063155_make_web_nullable_on_proposals_table	1
43	2021_07_24_220758_add_parent_id_to_funds_table	1
44	2021_07_24_223351_add_comment_prompt_to_proposals_table	1
45	2021_07_25_024907_remove_fund_column_from_proposals_table	1
46	2021_07_28_203637_add_team_id_column_to_proposals_table	1
47	2021_07_29_043607_add_columns_to_teams_table	1
48	2021_07_31_131200_create_snippets_table	1
49	2021_07_31_162116_add_rewarded_at_to_funds_table	1
50	2021_07_31_175803_add_awarded_at_to_funds_table	1
51	2021_08_01_212936_add_indexes_to_proposals_table	1
52	2021_08_01_213405_add_indexes_to_posts_table	1
53	2021_08_01_213604_add_indexes_to_users_table	1
54	2021_08_03_160527_make_team_id_big_int_on_proposals_table	1
55	2021_08_06_043018_drop_columns_from_snippets_table	2
56	2021_08_07_205348_create_model_snippets_table	2
57	2021_08_07_220325_change_snippets_column_type	2
58	2021_08_15_170647_create_links_table	2
59	2021_08_16_165802_model_links_table	2
60	2021_08_16_170337_remove_model_fields_from_links_table	2
61	2021_08_16_172139_add_timestamps_and_soft_deletes_to_links_table	2
62	2021_08_16_172511_add_nullables_to_links_table	2
63	2021_09_03_223027_create_discussions_table	2
64	2021_09_04_104029_create_ratings_table	2
65	2021_09_04_173453_add_comment_prompts_to_discussions_table	2
66	2021_09_16_050551_make_published_at_nullable_on_posts	2
67	2021_09_27_121820_update_published_at_column_on_posts_table	2
68	2021_09_27_225539_create_translations_table	2
69	2021_09_30_142455_make_posts_table_translatable	2
70	2021_09_30_164148_make_posts_table_translatable_step_2	2
71	2021_09_30_164330_make_posts_table_translatable_step_3	2
72	2021_10_04_051041_make_source_id_big_int_on_translations_table	2
73	2021_10_07_020208_add_stake_address_to_users_table	2
74	2021_10_11_000924_create_causes_table	2
75	2021_10_19_052140_add_published_at_to_comments	3
76	2021_10_24_165631_db_optimizations	4
78	2021_10_31_055710_add_ideascale_link_to_proposals	6
81	2021_10_28_184345_create_mints_table	7
82	2021_11_10_063524_create_mint_txes_table	7
83	2021_11_17_131306_add_voting_id_to_causes_table	8
84	2021_11_21_174644_add_voting_code_to_causes_table	9
85	2021_12_22_041066_make_snippets_table_translatable	10
86	2021_12_22_041322_make_snippets_table_translatable_step_2	10
87	2021_12_22_041426_make_snippets_table_translatable_step_3	10
88	2022_01_04_183813_add_type_to_comments_table	11
89	2022_01_16_040752_create_votes_table	12
90	2022_01_16_145350_create_wallets_table	13
91	2022_01_17_175531_create_model_wallets_table	14
92	2022_02_12_134827_create_stats_table	15
93	2022_02_16_201618_add_type_column_to_proposals_table	16
94	2022_03_13_171416_make_proposal_fields_translatable	17
95	2022_04_02_134717_create_settings_table	18
96	2022_04_06_224416_create_catalyst_users_table	19
97	2022_04_07_021923_proposal_catalyst_user	19
98	2022_04_09_192202_add_funding_columns_to_proposals_table	20
99	2022_04_10_135612_char_types_on_proposals_table	21
100	2022_04_11_135612_add_socials_to_catalyst_users_table	22
101	2022_04_16_140308_add_missing_discussions	23
102	2022_04_16_181652_change_proposal_type_column	24
103	2021_08_25_193039_create_nova_notifications_table	25
104	2022_04_22_114057_add_color_column_to_funds_table	26
105	2022_04_24_140308_add_missing_discussions	27
106	2022_04_24_140308_add_missing_discussions	27
107	2022_04_26_021923_catalyst_user_catalyst_group	28
108	2022_04_26_052951_create_catalyst_groups_table	28
109	2022_04_27_031923_proposal_catalyst_group	28
110	2022_04_27_041954_create_catalyst_intents_table	29
111	2022_04_26_000000_add_fields_to_nova_notifications_table	30
112	2022_05_05_002941_create_events_table	30
113	2022_05_07_225704_add_preview_url_to_snippets_table	31
114	2022_05_08_022404_add_slug_to_catalyst_groups	32
115	2022_05_11_000302_set_proposal_primary_author	33
116	2022_05_11_000302_set_proposal_primary_author	33
117	2022_05_14_021704_add_links_to_catalyst_groups_table	34
118	2022_05_27_121958_create_funds_lable_table	35
119	2022_05_29_135221_rename_comments_to_legacy_comments	36
120	2022_05_29_135222_migrate_comments_to_legacy_comments	36
121	2022_05_30_135221_create_comments_tables	36
122	2022_05_29_135222_migrate_comments_to_legacy_comments	37
123	2022_05_30_215217_migrate_comments_to_new_model	36
124	2022_07_04_142147_add_currency_to_funds_table	38
125	2022_07_06_162758_add_iog_hash_to_proposals_table	39
126	2022_07_06_162758_add_iog_hash_to_proposals_table	39
130	2022_08_17_204301_create_assessment_review_comments_table	40
131	2022_08_17_230132_create_assessment_reviews_table	40
132	2022_08_18_034003_create_assessors_table	40
133	2022_08_20_195256_create_anonymous_bookmarks_table	41
134	2022_09_09_072152_add_subtitle_to_posts	42
135	2022_09_18_084938_create_twitter_events_table	43
136	2022_09_18_085340_create_twitter_attendances_table	43
137	2022_09_19_083344_add_events_post_column_to_twitter_events	44
138	2022_09_21_133052_index_metas_table	45
139	2022_09_21_222313_create_catalyst_reports_table	46
140	2022_09_24_002819_add_index_to_catalyst_users_table	47
141	2022_09_27_194621_add_type_to_funds_table	48
142	2022_09_29_024253_add_policy_id_to_mint_txs_table	49
149	2022_10_05_183839_create_podcasts_table	50
150	2022_10_05_184146_create_nfts_table	50
151	2022_10_05_193248_create_podcast_shows_table	50
152	2022_10_05_193812_create_podcast_seasons_table	50
153	2022_10_10_003800_change_status_column_on_snippets_table	51
154	2022_10_12_150539_index_proposals_table	52
155	2022_10_17_040654_update_catalyst_users_table_schema	53
156	2022_10_18_052759_create_txes_table	53
157	2022_10_18_060635_add_qty_to_nfts_table	53
158	2022_11_03_021736_create_temporary_uploads_table	54
160	2022_11_09_235245_create_promos_table	55
161	2022_11_15_095819_add_color_column_to_tags_table	56
162	2022_11_15_100050_add_color_column_to_categories_table	56
163	2022_11_20_000833_add_status_column_to_promos_table	57
166	2022_11_29_204612_create_questions_table	58
167	2022_11_29_204851_create_question_quiz_table	58
171	2022_11_30_134148_add_passphrase_to_wallets_table	58
175	2022_12_02_011608_create_every_epoches_table	59
176	2022_12_02_012840_model_quiz_pivot_table	59
177	2022_11_29_191814_create_answer_responses_table	60
178	2022_11_29_203248_create_question_answers_table	60
180	2022_11_29_210312_create_giveaway_model_table	60
181	2022_11_29_210539_create_quizzes_table	60
183	2022_12_03_165336_make_columsn_nullable_on_wallets_table	61
184	2022_11_29_205217_create_giveaways_table	62
185	2022_11_30_134312_create_rewards_table	62
186	2022_12_04_183841_create_rules_table	62
187	2022_12_10_065350_add_tx_metadata_column_to_giveaways_table	63
188	2022_12_11_190000_ccv4_ballot_choice	64
189	2022_12_17_212014_create_withdrawals_table	65
190	2022_12_17_212343_add_withrawals_foreign_key_to_rewards_table	65
191	2022_12_21_095135_add_assessment_started_at_column_to_funds_table	66
192	2023_01_03_101123_create_catalyst_groups_indexes	67
193	2023_01_03_102838_create_catalyst_reports_index	67
194	2023_01_03_104051_create_indexes_on_proposals_table	67
195	2023_01_03_125741_create_indexes_on_funds_table	67
196	2023_01_03_143823_create_proposal_ratings_reviews_view	68
197	2023_01_26_151354_insert_move_content	69
198	2023_01_28_072623_add_tags_indexes	70
199	2023_01_28_072624_add_categories_indexes	70
200	2023_01_28_174827_add_wallet_id_and_spending_password_to_columns_to_wallets_table	71
201	2023_02_02_180851_create_notification_request_templates_table	71
202	2023_02_02_181335_create_notification_requests_table	71
203	2022_12_19_000000_create_field_attachments_table	72
204	2023_02_11_221946_add_claimed_by_to_catalyst_users	73
205	2023_02_15_212055_add_columsn_to_users_table	74
206	2023_02_18_195304_add_subject_id_to_notification_request_templates_table	75
207	2023_02_19_072158_create_repos_table	76
208	2023_02_19_072502_create_commits_table	76
209	2023_02_24_170224_add_telegram_column_to_catalyst_users_table	77
210	2023_03_01_201005_add_titles_to_catalyst_users	78
211	2023_03_16_155520_create_course_table	78
212	2023_03_17_230445_insert_catalyst_explorer_proposals_translations	78
213	2023_03_18_035240_create_bookmark_collections_table	78
214	2023_03_18_035343_create_bookmark_items_table	78
215	2023_03_18_114843_create_lido_reactions_table	78
216	2023_03_16_165432_create_lessons_table	79
217	2023_03_17_045219_create_lesson_post_table	79
218	2023_03_21_180212_make_commenter_id_nullable_in_lido_reactions_table	79
220	2023_03_31_115813_add_deleted_at_column_on_collection_item	81
221	2023_04_04_035159_add_learn_landing_page_snippets	82
222	2023_04_05_090143_add_how_to_buy_ada_snippets	83
224	2023_04_06_172616_test_snippets	84
229	2023_04_06_063807_create_learning_modules_table	85
230	2023_04_06_225355_create_learning_topics_table	85
231	2023_04_06_230930_create_learning_lessons_table	85
232	2023_04_06_231903_learning_module_learning_topic	85
233	2023_04_06_232458_learning_lesson_learning_topic	85
234	2023_04_12_212104_add_learner_role	86
235	2023_04_18_140120_insert_snippets_sub_menu_blade	87
236	2023_04_19_154145_make_stake_address_column_nullable_in_rewards_model	88
237	2023_04_18_140952_add_how_to_stake_your_ada_snippets	89
238	2023_04_28_155806_add_lesson_page_snippets_on_snippets_table	90
239	2023_04_29_073619_add_learn_popup_snippets	91
240	2023_04_29_155107_learn_attempts_migration	92
241	2023_04_29_195203_add_order_column_on_learningatopics_table	93
242	2023_04_30_000854_add_active_pool_id_column_to_users_table	93
243	2023_04_30_004300_create_jobs_table	93
244	2023_05_02_162559_add_lang_to_users_table	94
245	2023_05_18_125902_mark_users_verified	95
246	2023_05_31_161530_add_primary_account_column_to_users_table	96
247	2023_06_03_223521_add_duplicate_account_snippets	97
248	2023_06_17_150549_add_currency_to_proposals_table	98
249	2023_06_18_161952_set_fund_9_challenges_currency	98
250	2023_06_18_162209_set_funds_currency_usd	98
251	2023_06_22_162615_add_closed_registration_snippets	99
252	2023_06_27_205234_add_context_to_answer_responses_table	100
254	2023_07_04_020307_answer_responses_addind_context_id	101
255	2023_07_11_174548_add_type_to_bookmark_collections_table	102
256	2023_07_13_040756_add_action_column_to_bookmark_collections_table	103
257	2023_07_15_124301_add_open_source_column_to_proposas	104
258	2023_07_15_133657_create_catalyst_votes_table	104
259	2023_07_23_071346_add_policy_to_learningtopic_nfts	105
260	2023_07_23_084558_add_context_id_to_answer_response	106
261	2023_07_24_220921_create_job_batches_table	107
262	2023_07_20_211423_add_rank_column_to_table	108
263	2023_07_21_080634_create_catalyst_ranking_table	108
264	2023_07_27_081641_reward_unrewarded_lessons	109
265	2023_08_06_105512_add_quickpitch_column_proposals	110
266	2023_08_06_113419_add_quickpitches_from_meta	110
267	2023_08_09_105709_create_catalyst_registrations_table	111
268	2023_08_09_105922_create_delegations_table	111
269	2023_08_13_170338_create_catalyst_flags_table	112
270	2023_08_22_181223_create_catalyst_snapshots_table	113
271	2023_08_22_181411_create_catalyst_voting_powers_table	113
272	2023_08_22_182752_create_catalyst_voters_view	113
273	2023_08_24_011330_remove_voting_powers_from_catalyst_registrations_table	113
274	2023_09_01_150519_update_voting_power_table	114
275	2023_09_04_155655_create_catalyst_tallies_table	115
276	2023_09_08_082115_create_catalyst_legder_snapshots_table	116
277	2023_09_08_103546_add_foreign_key_to_bookmark_items	117
278	2023_09_08_185407_add_updated_at_to_catalyst_tallies_table	118
279	2023_09_12_130441_add_context_to_catalyst_tallies_table	119
281	2023_09_19_154031_add_cat_id_to_delegations_table	120
282	2023_09_19_165121_index_voter_id_on_catatalyst_voting_powers_table	120
283	2023_09_22_174855_create_catalyst_voters_table	121
284	2023_09_24_111615_add_consumed_column_to_catalyst_voting_power_table	122
285	2023_10_01_082751_add_votes_cast_column_to_catalyst_voting_power_table	123
286	2023_09_28_195856_add_kind_and_frequency_columns_to_events_table	124
\.


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.migrations_id_seq', 286, true);


--
-- PostgreSQL database dump complete
--

