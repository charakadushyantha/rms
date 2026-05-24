-- ============================================
-- FIX EXISTING CANDIDATES
-- Add existing candidate users to candidate_details table
-- ============================================

USE cmsadver_rmsdb;

-- Insert existing candidate users into candidate_details table
-- Only insert if they don't already exist
INSERT INTO candidate_details (cd_name, cd_email, cd_phone, cd_status, cd_rec_username, cd_created_at, cd_gender, cd_source, cd_description)
SELECT 
    u.u_username as cd_name,
    u.u_email as cd_email,
    '' as cd_phone,
    'Interested' as cd_status,
    'system_migration' as cd_rec_username,
    COALESCE(u.created_at, NOW()) as cd_created_at,
    'Not Specified' as cd_gender,
    'Existing User Migration' as cd_source,
    'Migrated from users table' as cd_description
FROM users u
WHERE u.u_role = 'Candidate'
AND u.u_email NOT IN (SELECT cd_email FROM candidate_details);

-- Show results
SELECT 'Migration Complete!' as status;
SELECT COUNT(*) as total_candidates_in_users FROM users WHERE u_role = 'Candidate';
SELECT COUNT(*) as total_candidates_in_details FROM candidate_details;

-- ============================================
-- VERIFICATION
-- ============================================
-- Check if any candidates are still missing
SELECT 
    u.u_username,
    u.u_email,
    u.u_status,
    CASE 
        WHEN cd.cd_email IS NULL THEN 'MISSING IN candidate_details'
        ELSE 'OK'
    END as status
FROM users u
LEFT JOIN candidate_details cd ON u.u_email = cd.cd_email
WHERE u.u_role = 'Candidate';
