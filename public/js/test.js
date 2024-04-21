$(function(){
    $('#btn-finish').on('click', (function(){
        let testResult = {};

        $('.form-check-input').each(function() {
            let info = $(this).attr('id').split('-')
            let questionId = info[1]
            let answerId = info[2]

            if (! testResult.hasOwnProperty(questionId)) {
                testResult[questionId] = [];
            }

            if ($(this).is(':checked')) {
                testResult[questionId].push(answerId)
            }
        })

        console.log(testResult)

        $.ajax({
            url: '/test-check',
            method: 'post',
            dataType: 'json',
            data: {id: testId, data: JSON.stringify(testResult)},
            success: function(data) {
                console.log(data)
                location.href = 'results\\' + testId
            },
            error: function () {
                $('#alert-error').show()
            }
        })
    }))
})
