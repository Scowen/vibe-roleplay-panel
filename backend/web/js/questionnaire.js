$(document).ready(function () {
    let currentQuestionIndex = 0;
    let totalQuestions = $('.question-step').length;
    let userAnswers = {};
    let questionData = [];

    // Initialize questionnaire
    function initQuestionnaire() {
        console.log('Initializing questionnaire...');

        // Collect question data
        $('.question-step').each(function (index) {
            const $step = $(this);
            const questionText = $step.find('.question-header h2').text();
            const answers = [];
            let questionId = null;

            $step.find('.answer-radio').each(function () {
                const $radio = $(this);
                if (!questionId) {
                    questionId = $radio.attr('name').match(/answers\[(\d+)\]/)[1];
                }
                answers.push({
                    id: $radio.val(),
                    text: $radio.siblings('label').find('.answer-text').text(),
                    isCorrect: false // Will be determined on submission
                });
            });

            questionData.push({
                index: index,
                id: questionId,
                text: questionText,
                answers: answers
            });
        });

        console.log('Question data collected:', questionData);
        console.log('Total questions:', totalQuestions);

        updateProgress();
        setupEventListeners();
        console.log('Questionnaire initialized');
    }

    // Update progress bar and text
    function updateProgress() {
        const progress = ((currentQuestionIndex + 1) / totalQuestions) * 100;
        $('#progressFill').css('width', progress + '%');
        $('#currentQuestion').text(currentQuestionIndex + 1);
    }

    // Setup event listeners
    function setupEventListeners() {
        // Radio button selection
        $('.answer-radio').on('change', function () {
            const questionIndex = $(this).data('question');
            const answerId = $(this).val();

            console.log('Radio button changed - Question:', questionIndex, 'Answer:', answerId);

            userAnswers[questionIndex] = answerId;
            console.log('Updated user answers:', userAnswers);

            // Enable/disable next/submit button
            const $currentStep = $('.question-step[data-question="' + questionIndex + '"]');
            const $nextBtn = $currentStep.find('.btn-next');
            const $submitBtn = $currentStep.find('.btn-submit');

            if ($nextBtn.length) {
                $nextBtn.prop('disabled', false);
                console.log('Next button enabled');
            }
            if ($submitBtn.length) {
                $submitBtn.prop('disabled', false);
                console.log('Submit button enabled');
            }
        });

        // Next button
        $('.btn-next').on('click', function () {
            const questionIndex = $(this).data('question');
            goToQuestion(questionIndex + 1);
        });

        // Previous button
        $('.btn-prev').on('click', function () {
            const questionIndex = $(this).data('question');
            goToQuestion(questionIndex - 1);
        });

        // Submit button
        $('.btn-submit').on('click', function () {
            console.log('Submit button clicked');
            const questionIndex = $(this).data('question');
            console.log('Question index:', questionIndex);
            console.log('User answers for this question:', userAnswers[questionIndex]);
            if (userAnswers[questionIndex]) {
                submitQuestionnaire();
            } else {
                console.log('No answer selected for question', questionIndex);
                alert('Please select an answer before submitting.');
            }
        });


    }

    // Navigate to specific question
    function goToQuestion(index) {
        if (index < 0 || index >= totalQuestions) return;

        // Hide current question
        $('.question-step.active').removeClass('active');

        // Show new question
        $('.question-step[data-question="' + index + '"]').addClass('active');

        currentQuestionIndex = index;
        updateProgress();
    }

    // Submit questionnaire and show results
    function submitQuestionnaire() {
        console.log('Submitting questionnaire...');
        console.log('User answers:', userAnswers);
        console.log('Question data:', questionData);

        // Check if all questions are answered
        const answeredQuestions = Object.keys(userAnswers).length;
        if (answeredQuestions < totalQuestions) {
            alert('Please answer all questions before submitting. You have answered ' + answeredQuestions + ' out of ' + totalQuestions + ' questions.');
            return;
        }

        // Prepare form data
        const formData = new FormData();
        Object.keys(userAnswers).forEach(questionIndex => {
            const question = questionData[questionIndex];
            const answerId = userAnswers[questionIndex];
            console.log(`Adding answer: answers[${question.id}] = ${answerId}`);
            formData.append(`answers[${question.id}]`, answerId);
        });

        // Show loading state
        $('.btn-submit').prop('disabled', true).text('Submitting...');

        // Submit via AJAX
        $.ajax({
            url: window.location.href,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('AJAX response:', response);
                try {
                    // Try to parse JSON response
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }

                    if (response.success) {
                        showResults(true, response.results);
                    } else {
                        showResults(false, response.results);
                    }
                } catch (e) {
                    console.log('JSON parse error:', e);
                    // Fallback for non-JSON responses
                    if (response.includes('Thanks! You have passed')) {
                        showResults(true);
                    } else {
                        showResults(false);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', status, error);
                console.log('Response text:', xhr.responseText);
                showResults(false);
            },
            complete: function () {
                // Reset button state
                $('.btn-submit').prop('disabled', false).text('Submit Answers');
            }
        });
    }

    // Show results modal
    function showResults(passed, results = null) {
        let resultsHtml = '';

        if (passed) {
            resultsHtml = `
                <div class="text-center mb-4">
                    <div class="result-status pass">🎉 Congratulations! You Passed!</div>
                    <p class="mt-2">You have successfully completed the server rules questionnaire.</p>
                </div>
            `;
        } else {
            resultsHtml = `
                <div class="text-center mb-4">
                    <div class="result-status fail">❌ You Need to Try Again</div>
                    <p class="mt-2">Please review the correct answers and try again.</p>
                </div>
            `;
        }

        // Add question-by-question results
        resultsHtml += '<div class="results-breakdown">';

        if (results && results.length > 0) {
            // Use server-provided results
            results.forEach((result, index) => {
                resultsHtml += `
                    <div class="result-item ${result.isCorrect ? 'correct' : 'incorrect'}">
                        <div class="result-question">${result.question}</div>
                        <div class="result-answer ${result.isCorrect ? 'correct' : 'incorrect'}">
                            Your answer: ${result.userAnswer}
                        </div>
                    </div>
                `;
            });
        } else {
            // Fallback to client-side results
            questionData.forEach((question, index) => {
                const userAnswerId = userAnswers[index];
                const userAnswer = question.answers.find(a => a.id == userAnswerId);

                resultsHtml += `
                    <div class="result-item">
                        <div class="result-question">${question.text}</div>
                        <div class="result-answer">
                            Your answer: ${userAnswer ? userAnswer.text : 'No answer'}
                        </div>
                    </div>
                `;
            });
        }

        resultsHtml += '</div>';

        // Add retake button
        resultsHtml += `
            <div class="text-center mt-4">
                <button type="button" class="btn btn-primary btn-retake" onclick="retakeQuestionnaire()">
                    Retake Questionnaire
                </button>
            </div>
        `;

        // Replace questionnaire content with results
        $('.questionnaire-content').html(resultsHtml);

        // Hide progress bar since we're showing results
        $('.questionnaire-progress').hide();
    }

    // Function to retake the questionnaire
    window.retakeQuestionnaire = function () {
        // Reset user answers
        userAnswers = {};

        // Reset current question index
        currentQuestionIndex = 0;

        // Show progress bar again
        $('.questionnaire-progress').show();

        // Reset progress
        updateProgress();

        // Reinitialize the questionnaire
        initQuestionnaire();
    };

    // Initialize when document is ready
    initQuestionnaire();
});
